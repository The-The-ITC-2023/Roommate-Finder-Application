const logo = document.getElementById("logo");
const button1 = document.getElementById("button1");
const button2 = document.getElementById("button2");
const slogan = document.getElementsByTagName("h1");
const companyName = document.getElementsByTagName("h2");
const logoContainer = document.getElementById("logo-container");

console.log(button1);
window.onload=function(){
    button1.addEventListener('click' ,moveToCorner);
    button2.addEventListener('click' ,moveToCorner);
}

function moveToCorner(){
    //Setting logo to the top left
    logo.style.position = 'fixed';
    logo.style.left = 0;
    logo.style.top = 0;
    logoContainer.className = "upperLogo";
    removeHomeElements();
    document.location.href = "createAccount.php";
}

function removeHomeElements(){
    button1.remove();
    button2.remove();
    slogan[0].style.display = 'none';
    companyName[0].style.display = 'none'
}
function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
      currentDate = Date.now();
    } while (currentDate - date < milliseconds);
  }