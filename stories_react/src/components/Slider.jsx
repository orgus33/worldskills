import { useEffect, useRef } from "react";

const Slider = ({ index, slidersRefs, isActive, isPassed, duration }) => {
    const barRef = useRef();

    useEffect(() => {
        if (isActive && barRef.current) {
            barRef.current.style.transition = "none";
            barRef.current.style.width = "0%";
            void barRef.current.offsetWidth;
            barRef.current.style.transition = `width ${duration}s linear`;
            barRef.current.style.width = "100%";
        }
        if (!isActive && !isPassed && barRef.current) {
            barRef.current.style.transition = "none";
            barRef.current.style.width = "0%";
        }
        if (isPassed && barRef.current) {
            barRef.current.style.transition = "none";
            barRef.current.style.width = "100%";
        }
    }, [isActive, isPassed, duration]);

    return (
        <div className="h-1 rounded-xl w-full bg-gray-400 relative overflow-hidden" id={index}>
            <div
                ref={el => {
                    barRef.current = el;
                    slidersRefs.current[index] = el;
                }}
                className="progress-bar rounded-xl absolute left-0 top-0 bottom-0 bg-gray-50"
                style={{
                    width: isPassed ? "100%" : "0%",
                }}
            ></div>
        </div>
    );
};

export default Slider;