/*Write a Blog*/
var banner_pic=document.querySelector("#upload_pic");
var banner_pic_upload=document.querySelector("#banner_upload");
banner_pic_upload.onchange =  () => {
    banner_pic.src= URL.createObjectURL(banner_pic_upload.files[0]);
    console.log(blogData);
    }
    

