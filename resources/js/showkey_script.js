console.log('loaded showkey script');



export function showHubKey() {
    console.log('showKey called in appjs');
  var x = document.getElementById("gitHubInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}


export function showLabKey(){
    var y = document.getElementById("gitLabInput");
    if(y.type === 'password'){
    y.type = 'text';
    } else {
    y.type = 'password';
    }
}


document.querySelector('.showHubButton').addEventListener('click', showHubKey);
document.querySelector('.showLabButton').addEventListener('click', showLabKey);