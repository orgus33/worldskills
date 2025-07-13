import Slider from "./Slider.jsx";

const Sliders = ({ slidersRefs, person, currentSlider }) => {
    return (
        <div className="slides flex gap-4 mb-4">
            {person.slides.map((slide, i) => (
                <Slider
                    key={i}
                    index={i}
                    slidersRefs={slidersRefs}
                    isActive={i === currentSlider}
                    isPassed={i < currentSlider}
                    duration={slide.duration || 5}
                />
            ))}
        </div>
    );
};

export default Sliders;