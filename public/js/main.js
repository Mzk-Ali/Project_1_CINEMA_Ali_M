left_click = document.querySelectorAll(".left_button")
container_list = document.querySelectorAll(".container_list")
right_click = document.querySelectorAll(".right_button")

for (let i = 0; i < left_click.length; i++)
{
    left_click[i].addEventListener("click", function(){
        console.log("test");
        container_list[i].scrollBy(-14.5 * window.innerWidth/100,0);
    });
}

for (let i = 0; i < right_click.length; i++)
{
    right_click[i].addEventListener("click", function(){
        console.log("test right");
        container_list[i].scrollBy(14.5 * window.innerWidth/100, 0);
    });
}

