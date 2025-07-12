import Slider from "./Slider.jsx";
import {useEffect, useState} from "react";

const Sliders = ({slidersRefs}) => {
    const [animation, setAnimation] = useState(undefined)
    const [currentSlider, setCurrentSlider] = useState(0)

    useEffect(() => {

        clearInterval(interval);
        if (typeof animation !== "undefined") {
            animation.cancel();
        }

        if (currentSlider > slidersRefs.children.length - 1) {
            closeStory();
            return;
        }



    }, []);

    return (
        <div className="slides flex gap-4 mb-4">
            {person.slides.forEach((slide, i) => (
                <Slider slidersRefs={slidersRefs}/>
            ))}
        </div>
    )
}

export default Sliders;