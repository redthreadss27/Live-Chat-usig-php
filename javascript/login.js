var f = document.querySelector('#fname');
// alert("lmckk");

const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button3 input"),
errorText = form.querySelector(".error-txt");
//alert(continueBtn);
form.onsubmit = (e)=>{
    e.preventDefault(); //preventing form from submitting
}


continueBtn.addEventListener('click', () =>{
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../live chat/php/login.php',true);
   // xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = () => {
    if (xhr.status == 200) {
      let data = xhr.response;
      console.log(data);
      
      if(data == "success"){
        location.href = "users.php";
      }else{
        errorText.style.display = "block";
        errorText.textContent = data;
      }

    }
    
  };
  // we have to send the form data through ajas to php
  let formData = new FormData(form);//creating new formData object
  xhr.send(formData);//sending the form data to php


}

)