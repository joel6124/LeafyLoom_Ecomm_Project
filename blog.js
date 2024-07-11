// /*Blog Page*/
// function getdate()
// {
//     var currentDate = new Date();
//     var strdate=String(currentDate);
//     var date_arr=strdate.split(" ");
//     var blog_date=date_arr[2]+" "+date_arr[1]+", "+date_arr[3];
//     return blog_date;
// }

// var blogData = [
//     {
//         title: "10 Ways to Reduce Plastic Pollution",
//         image: "img/bulk-purchases.jpg",
//         description: "We all know that plastic is one of the most excessively used materials...",
//         link: "#",
//         date:getdate()
        
//     },
//     {
//         title: "15 Sustainable Corporate Gift Ideas for Employees in 2023",
//         image: "img/eco_book.jpg",
//         description: "Corporate gifting has reached an all-time high. Corporate gifts now a days...",
//         link: "#",
//         date:getdate()

//     },
//     {
//         title: "How to celebrate eco-friendly Holi?",
//         image: "img/nat_holi.jpg",
//         description: "Holi is the festival of colors and celebrating a united spirit with great enthusiasm...",
//         link: "#",
//         date:getdate()
//     },
//     {
//         title: "10 Ways to Reduce Plastic Pollution",
//         image: "img/bulk-purchases.jpg",
//         description: "We all know that plastic is one of the most excessively used materials...",
//         link: "#",
//         date:getdate()
//     },
//     {
//         title: "15 Sustainable Corporate Gift Ideas for Employees in 2023",
//         image: "img/eco_book.jpg",
//         description: "Corporate gifting has reached an all-time high. Corporate gifts now a days...",
//         link: "#",
//         date:getdate()
//     },
//     {
//         title: "How to celebrate eco-friendly Holi?",
//         image: "img/nat_holi.jpg",
//         description: "Holi is the festival of colors and celebrating a united spirit with great enthusiasm...",
//         link: "#",
//         date:getdate()
//     }
// ];


// function createBlogCard(title, image, description, link,date) 
// {
//     var blogCard = document.createElement("div");
//     blogCard.classList.add("blog-card");
//     blogCard.innerHTML = `
//         <img src="${image}" class="blog-img" alt="">
//         <p class="date_of_publish">${date}</p>
//         <h1 class="blog-title">${title}</h1>
//         <p class="blog-desc">${description}</p>
//         <a href="${link}" class="blog_btn read">Read</a>
//     `;
//     return blogCard;
// }


// var blogSection = document.getElementById("blogSection");
// for (var i = 0; i < blogData.length; i++) {
//     var blogCard = createBlogCard(blogData[i].title, blogData[i].image, blogData[i].description, blogData[i].link,blogData[i].date);
//     blogSection.appendChild(blogCard);
// }


// // function publish()
// // {
    

// //     // console.log("ejllo");
// //     // blogData.push({
// //     //     title: document.querySelector(".title").value,
// //     //     image: "img/nat_holi.jpg",
// //     //     description: document.querySelector(".article").value,
// //     //     link: "#",
// //     //     date:getdate()
// //     // });


// //     // blog_added=(blogData.pop());
// //     // alert(blog_added);
// //     // var blogSection = document.getElementById("blogSection");
// //     // var new_blogCard=createBlogCard(blog_added.title,blog_added.image,blog_added.description,blog_added.link,blog_added.date);
// //     // blogSection.appendChild(new_blogCard);
// // }

