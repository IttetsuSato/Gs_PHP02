const Peer = window.Peer;

(async function main() {
  const localVideo = document.getElementById('js_local_stream');
  const joinTrigger = document.getElementById('js_join_trigger');
  const leaveTrigger = document.getElementById('js_leave_trigger');
  const remoteVideos = document.getElementById('js_remote_streams');
  const roomId = document.getElementById('js_room_id'); //room name
  const localText = document.getElementById('js_local_text');
  const sendTrigger = document.getElementById('js_send_trigger');
  const messages = document.getElementById('js_messages');
  const sdkSrc = document.querySelector('script[src*=skyway]');
    
  const localStream = await navigator.mediaDevices
    .getUserMedia({
      audio: true,
      video: true,
    })
    .catch(console.error);

  localVideo.muted = true;
  localVideo.srcObject = localStream;
  localVideo.playsInline = true;
  await localVideo.play().catch(console.error);

  //Peer(通信拠点の単位となるオブジェクト)
  const peer = new Peer({
    key: 'a6432d6c-a006-47b7-adc8-b25e5a232a1d', //APIkey
    debug: 3 //ログ出力レベル[3:all]
  });

  //参加処理
  joinTrigger.addEventListener('click', () => {
    //エラー処理
    peer.on('error', console.error);
      
      if (!peer.open) {
        return;
      }
      
      //callメソッドでroomとの接続時、自分の情報を送信
      const room = peer.joinRoom(roomId.value, {
        mode: 'sfu',
        stream: localStream,
      });
      //チャット参加報告
      room.once('open', () => {
        messages.textContent += '=== You joined ===\n';
      });
      room.on('peerJoin', peerId => {
        messages.textContent += `=== ${peerId} joined ===\n`;
      });
      
      //新規入室者の映像取得
      room.on('stream', async stream => {
        //video要素にカメラ映像をセットして再生
        const newVideo = document.createElement('video');
        newVideo.srcObject = stream;
        newVideo.playsInline = true;
        // mark peerId to find it later at peerLeave event
        newVideo.setAttribute('data_peer_id', stream.peerId);
        remoteVideos.append(newVideo);
        await newVideo.play().catch(console.error);
      });
      
      //チャット
      room.on('data', ({ data, src }) => {
        messages.textContent += `${src}: ${data}\n`;
      });
      
      //メンバー退出処理
      room.on('peerLeave', peerId => {
        const remoteVideo = remoteVideos.querySelector(
          `[data_peer_id="${peerId}"]`
          );
          remoteVideo.srcObject.getTracks().forEach(track => track.stop());
          remoteVideo.srcObject = null;
          remoteVideo.remove();
          messages.textContent += `=== ${peerId} lefted ===\n`;
        });
        
        //自身の退出処理
        room.once('close', () => {
          sendTrigger.removeEventListener('click', onClickSend);
          messages.textContent += '== You left ===\n';
          Array.from(remoteVideos.children).forEach(remoteVideo => {
            remoteVideo.srcObject.getTracks().forEach(track => track.stop());
            remoteVideo.srcObject = null;
            remoteVideo.remove();
          });
        });
        
        //チャット
        sendTrigger.addEventListener('click', onClickSend);
        function onClickSend() {
          room.send(localText.value);
          messages.textContent += `${peer.id}: ${localText.value}\n`;
          localText.value = '';
        }
        
        leaveTrigger.addEventListener('click', () => room.close(), { once: true });
        });//入室ボタン
      
    })();
    