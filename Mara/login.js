const username=document.getElementById('username');
        const password=document.getElementById('password');
        const loginButton=document.getElementById('login');
        const passError=document.getElementById('passError');
        //check username-only alphabets
          
        //check password-min length in characters
        function checkPassword(){
            //pick password by user
            const passValue=password.value;
            if (passValue.length<8){
passError.textContent='Password should have  a minimum of eight characters '
            }
            else{
                passError.textContent='';
            }
        }
//add events to the password input
password.addEventListener('input',checkPassword);

//add event to the login button
loginButton.addEventListener('click',function(event){
    //prevent default action of the button
    event.preventDefault();
    //check if login is successful
    if (email.value===''&&password.value===''){
        alert('Login successful!');
    }
    else{
        alert('Login failed!');
    }
});