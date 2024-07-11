let profile = document.getElementById("user_pf");
let subMenu = document.getElementById("subMenu");

profile.addEventListener('click', () => {
    subMenu.classList.toggle('open-menu');
    preventDefault();
});


document.addEventListener("DOMContentLoaded", function() 
{
    var navbarLinks = document.querySelectorAll("#navbar li a");
    for (var i = 0; i < navbarLinks.length; i++) 
    {
        navbarLinks[i].addEventListener("click", function(event) 
        {
            for (var j = 0; j < navbarLinks.length; j++) 
            {
                navbarLinks[j].classList.remove("active");
            }
            event.currentTarget.classList.add("active");
        });
    }

    // Check the URL for anchor(#) and set "active" class
    var currentUrl = window.location.href;
    var hashIndex = currentUrl.indexOf("#");
    if (hashIndex !== -1) 
    {
        var targetAnchor = currentUrl.substring(hashIndex + 1);
        var targetLink = document.querySelector('a[href="#' + targetAnchor + '"]');
        if (targetLink) 
        {
            for (var j = 0; j < navbarLinks.length; j++) 
            {
                navbarLinks[j].classList.remove("active");
            }
            targetLink.classList.add("active");
        }
    }
});

// for navbar about  id="abt-navigate"
// const abt_nav=document.querySelector("#abt-navigate");
// abt_nav.on

// const navbar = document.querySelector("#navbar");
//             const cartSection = document.querySelector("#cart");
//             const offsetTop = cartSection.offsetTop - (navbar.offsetHeight+100);
//             window.scrollTo({ top: offsetTop, behavior: 'smooth' });







// const login_popup=document.querySelector(".wrapper");
// const loginlink=document.querySelector(".login-link");
// const registerlink=document.querySelector(".register-link");

// registerlink.addEventListener('click',() => {
//     login_popup.classList.add('active');
// });

// loginlink.addEventListener('click',() => {
//     login_popup.classList.remove('active');
// });




// /*register validation*/
// function validateRegistration() 
// {
//     // Validation for First Name
//     var firstName = document.getElementById("fname").value;
//     if (!/^[a-zA-Z]{6,}$/.test(firstName)) {
//         alert("First Name should contain alphabets and be at least 6 characters long.");
//         return false;
//     }

//     // Validation for Last Name
//     var lastName = document.getElementById("lname").value;
//     if (lastName.trim() === "") {
//         alert("Last Name cannot be empty.");
//         return false;
//     }

//     // Validation for Password
//     var password = document.getElementById("paswd_register").value;
//     if (password.length < 6) {
//         alert("Password should be at least 6 characters long.");
//         return false;
//     }

//     // Validation for Email
//     var email = document.getElementById("e-id").value;
//     if (!/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
//         alert("Invalid Email address.");
//         return false;
//     }

//     // Validation for Mobile Number
//     var mobileNumber = document.getElementById("ph_no").value;
//     if (!/^\d{10}$/.test(mobileNumber)) {
//         alert("Mobile Number should contain 10 digits only.");
//         return false;
//     }

//     // Validation for Address
//     var address = document.getElementById("address").value;
//     if (address.trim() === "") 
//     {
//         alert("Address cannot be empty.");
//         return false;
//     }

//     // All validations passed
//     return true;
// }



//navbar
// let subMenu=document.getElementById("subMenu");
// subMenu.addEventListener('click',() => {
//     subMenu.classList.add('open-menu');
// });

//Login register
// const login_popup=document.querySelector(".wrapper");
// const loginlink=document.querySelector(".login-link");
// const registerlink=document.querySelector(".register-link");

// registerlink.addEventListener('click',() => {
//     login_popup.classList.add('active');
// });

// loginlink.addEventListener('click',() => {
//     login_popup.classList.remove('active');
// });



// //navbar
// let subMenu=document.getElementById("subMenu");
// subMenu.addEventListener('click',() => {
//     subMenu.classList.add('open-menu');
// });


// function toggleMenu()
// {
//     console.log("jd");
//    subMenu.classList.toggle("open-menu"); 
// }






// /*Login*/
// function validate_login()
// {
//     var returnval=true;
//     var uname=document.querySelector("#uname");
//     var paswd=document.querySelector("#paswd");
//     if(uname.value.trim()!="joeljino04@gmail.com" || paswd.value.trim()!="1234")
//     {
//         console.log("hello")
//         alert("Invalid username or password!!");
//         returnval=false;
//     }
//     else
//     {
//         alert("Login Sucessfull!!");
//     }
//     return returnval;
// }



// /*register validation*/
// function validateRegistration() {
//     // Validation for First Name
//     var firstName = document.getElementById("fname").value;
//     if (!/^[a-zA-Z]{6,}$/.test(firstName)) {
//         alert("First Name should contain alphabets and be at least 6 characters long.");
//         return false;
//     }

//     // Validation for Last Name
//     var lastName = document.getElementById("lname").value;
//     if (lastName.trim() === "") {
//         alert("Last Name cannot be empty.");
//         return false;
//     }

//     // Validation for Password
//     var password = document.getElementById("paswd_register").value;
//     if (password.length < 6) {
//         alert("Password should be at least 6 characters long.");
//         return false;
//     }

//     // Validation for Email
//     var email = document.getElementById("e-id").value;
//     if (!/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
//         alert("Invalid Email address.");
//         return false;
//     }

//     // Validation for Mobile Number
//     var mobileNumber = document.getElementById("ph_no").value;
//     if (!/^\d{10}$/.test(mobileNumber)) {
//         alert("Mobile Number should contain 10 digits only.");
//         return false;
//     }

//     // Validation for Address
//     var address = document.getElementById("address").value;
//     if (address.trim() === "") {
//         alert("Address cannot be empty.");
//         return false;
//     }

//     // All validations passed
//     return true;
// }

