const form =  document.querySelector(".typing-area"),
inputfield = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

// if(!searchBar.classList.contains("active")){ //if active not contains in search bar then add this data
//   //userslist.innerHTML = data;
// }

form.onsubmit = (e)=>{
    e.preventDefault(); //preventing form from submitting
}

sendBtn.onclick = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../live chat/php/insert_chat.php',true);
   // xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = () => {
    if (xhr.status == 200) {
      inputfield.value = "";//once messag inserted into database then leave blank textbox
      scrollToBottom();
    }
    
  };
  // we have to send the form data through ajas to php
  let formData = new FormData(form);//creating new formData object
  xhr.send(formData);//sending the form data to php
}

chatBox.onmouseenter=() =>{
  chatBox.classList.add("active");
}
chatBox.onmouseleave=() =>{
  chatBox.classList.remove("active");
}

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../live chat/php/get_chat.php',true);
   // xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = () => {
    if (xhr.status == 200) {
      let data = xhr.response;
      chatBox.innerHTML = data;
      if(!chatBox.classList.contains("active")){ //if aactive class not contains in chatbox the scroll to bottom
        scrollToBottom();
      }
    }
    
  };
  let formData = new FormData(form);//creating new formData object
  xhr.send(formData);//sending the form data to php
  //xhr.send();
}, 500);

function scrollToBottom(){
  chatBox.scrollTop = chatBox.scrollHeight;
}