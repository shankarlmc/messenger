const form = document.querySelector(".profile_edit_form__"),
inpFile = document.querySelector("#profile_pic");

form.onsubmit = (e)=>{
    e.preventDefault();
}


function changeProfile(event){
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('current__profile__pic');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "config/profile-edit.php", true);

    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              console.log(xhr.response);
              form.reset();
          }
      }
    }
    let formData = new FormData(form);
    for(const file of inpFile.files) {
      formData.append("myFiles[]", file);
    }
    xhr.send(formData);
}
