left_click = document.querySelectorAll(".left_button")
container_list = document.querySelectorAll(".container_list")
right_click = document.querySelectorAll(".right_button")

for (let i = 0; i < left_click.length; i++)
{
    left_click[i].addEventListener("click", function(){
        container_list[i].scrollBy(-14.5 * window.innerWidth/100,0);
    });
}

for (let i = 0; i < right_click.length; i++)
{
    right_click[i].addEventListener("click", function(){
        container_list[i].scrollBy(14.5 * window.innerWidth/100, 0);
    });
}




alert_btn_click = document.querySelector(".close_btn_alert")
alert_container_click = document.querySelector(".container_alert")

alert_btn_click.addEventListener("click", function(){
    console.log("test")
    alert_container_click.classList.remove("show");
    alert_container_click.classList.add("hide");
});

