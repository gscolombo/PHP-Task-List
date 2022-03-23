export default function mobileScroll() {
    const container = document.querySelector(".container");
    const position = {initial: 0, distance:0, lastDistance: 0, finalDistance: 0, index: 0};

    function setTransition(active) {
        container.style.transition = active ? "transform .4s ease-out" : "";
    }

    function calcMousePos(x) {
        position.distance = (position.initial - x) * 1.5;
        return position.lastDistance - position.distance;
    }

    function transition(direction){

        switch(direction) {
            case "right":
                if (position.index === 0) {
                    if (position.distance >= 75) {
                        container.style.transform = `translate3d(${-container.clientWidth}px, 0, 0)`;
                        position.finalDistance = -container.clientWidth;
                        position.index = 1;
                    } else {
                        container.style.transform = `translate3d(0px, 0, 0)`;
                        position.finalDistance = 0;
                    }
                }
                
                break;
            case "left":
                if (position.index === 1) {
                    if (position.distance <= -75) {
                        container.style.transform = `translate3d(0px, 0, 0)`;
                        position.finalDistance = 0;
                        position.index = 0;
                    } else {
                        container.style.transform = `translate3d(${-container.clientWidth}px, 0, 0)`;
                        position.finalDistance = -container.clientWidth;
                    }
                }
                break;
        }        
    }

    function start(event){
        position.initial = event.touches[0].clientX
        setTransition(false);

        container.addEventListener("touchmove", e => {
            move(e);
        });
    }

    function move(event){        
        const distance = calcMousePos(event.changedTouches[0].clientX);
        position.direction = distance - position.lastDistance < 0 ? "right" : "left";

        if (distance < 0 && distance > -container.clientWidth) {
            container.style.transform = `translate3d(${distance}px, 0, 0)`;
            position.finalDistance = distance;
        } else if (distance > 0) {
            container.style.transform = `translate3d(0px, 0, 0)`;
            position.finalDistance = 0;
        } else if (distance < -container.clientWidth) {
            container.style.transform = `translate3d(${-container.clientWidth}px, 0, 0)`;
            position.finalDistance = -container.clientWidth;
        }
    }

    function stop(){
        setTransition(true);
        transition(position.direction)
        position.lastDistance = position.finalDistance;
    }

    container.addEventListener("touchstart", e => {
        start(e);
    });
    container.addEventListener("touchend", e => {
        stop(e);
    });
}