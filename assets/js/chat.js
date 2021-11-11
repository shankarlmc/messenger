const form = document.querySelector(".messenger__form"),
current_user = form.querySelector(".current_user").value,
sender = form.querySelector(".sender__").value,
inputField = form.querySelector(".message__area"),
sendBtn = form.querySelector("#__send__message"),
chatBox = document.querySelector(".chatappend"),
inpFile = document.querySelector("#myMedia");

// Load all the seen messages on page reload
loadSeenMessages();

form.onsubmit = (e)=>{
    e.preventDefault();
}
// inputField.addEventListener('keyup',isTyping);

// function isTyping(){
//   let msg = inputField.value;
//     if(msg != ""){
//       inputField.classList.add("typing");
//     }else{
//       inputField.classList.remove("typing");
//     }
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "config/typing.php", true);
//     xhr.onload = ()=>{
//       if(xhr.readyState === XMLHttpRequest.DONE){
//           if(xhr.status === 200){
//             let data = xhr.response;
//             // var li = document.createElement("li");
//             // li.appendChild(document.createTextNode("Four"));
//             // chatBox.appendChild(li);
//             // chatBox.innerHTML = data;
//           }
//       }
//     }
//     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhr.send("currentuser=" + current_user);
// }


sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "config/upload-chat.php", true);
    sendBtn.setAttribute("disabled", true);
    sendBtn.classList.add("disabled");
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              form.reset();
              // sendBtn.setAttribute("disabled", false);
              // sendBtn.classList.remove("disabled");
              loadUnseenMessages();
              checkMsgList();
          }
      }
    }
    let formData = new FormData(form);
    for(const file of inpFile.files) {
      formData.append("myFiles[]", file);
    }
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

// load seen messages
function loadSeenMessages() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "config/load-messages.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            if(data != ''){
              chatBox.innerHTML = data;
              if(!chatBox.classList.contains("active")){
                checkMsgList();
              }
            } else {
              chatBox.classList.add('has-no-messages');
              const error = `<div class="alert alert-warning fade show text-center">
                <strong><span style="font-size:15px">&#x0021;</span> No messages are available. Once you send message they will appear here.</strong>
              </div>
              `;
              chatBox.innerHTML = error;
            }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("receiver="+current_user+"&msg_type="+"read");
}
// load unseen messages
function loadUnseenMessages() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "config/load-messages.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(data != '') {
            if(chatBox.classList.contains("has-no-messages")) {
              chatBox.innerHTML = '';
              chatBox.classList.remove("has-no-messages");
              $('.chatappend').append(data);
              checkMsgList();
              updateMessageStatus(current_user);
            } else {
              $('.chatappend').append(data);
              checkMsgList();
              updateMessageStatus(current_user);
            }
          }
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("receiver="+current_user+"&msg_type="+"unread");
}
// set timeout function to check unseen message is
// available or not
setInterval( ()=> {
  // check unread messaes at every 1sec
  loadUnseenMessages();
}, 500);

// change the messages Status
function updateMessageStatus(receiver){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "config/message-status.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          console.log('done');
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("receiver="+receiver);
}

function checkMsgList(){
  const msgList = document.querySelectorAll(".msg-list");
  if(msgList.length > 5){
    setTimeout(function(){
      last = msgList[msgList.length-1];
      last.scrollIntoView();
    },100);

  }else{
    return false;
  }
}
