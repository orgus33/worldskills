import Sliders from "./Sliders.jsx";
import {useEffect, useState} from "react";

const Story = ({person, slidersRefs, closeStory, containerLocation, setContainerLocation, prevBtnAction, nextBtnAction, intervalId, setIntervalId, currentSlider, setCurrentSlider}) => {
    const [sinceDate, setSinceDate] = useState("");

    useEffect(() => {
        if (!person) return;
        const slide = person.slides[currentSlider];
        setSinceDate(slide.date);

        if (slide.location) {
            setContainerLocation(slide.location.text);
        } else {
            setContainerLocation("");
        }

        clearInterval(intervalId);
        const duration = slide.duration ? slide.duration * 1000 : 5000;
        const id = setTimeout(() => {
            if (currentSlider < person.slides.length - 1) {
                setCurrentSlider(currentSlider + 1);
            } else {
                closeStory();
            }
        }, duration);
        setIntervalId(id);

        return () => clearTimeout(id);
    }, [currentSlider, person]);

    const calculateSinceDate = (date) => {
        const testDate = new Date(date)
        const nowDate = new Date()
        let sinceDate = nowDate.getTime() - testDate.getTime();

        let dateText = "";

        if ((sinceDate / 1000 / 60 / 60 / 24) >= 1) {
            dateText = Math.round(sinceDate / 1000 / 60 / 60 / 24) + " d"
        } else if ((sinceDate / 1000 / 60 / 60) >= 1) {
            dateText = Math.round(sinceDate / 1000 / 60 / 60) + " h"
        } else if ((sinceDate / 1000 / 60) >= 1) {
            dateText = Math.round(sinceDate / 1000 / 60) + " m"
        } else {
            dateText = Math.round(sinceDate / 1000) + " s";
        }

        return dateText
    }

    return (
        <div className="story absolute top-0 left-0 bottom-0 right-0 bg-gray-800 px-2 py-3 z-1">
            <div onClick={prevBtnAction} className="prev w-25 h-full absolute top-0 left-0 cursor-pointer"></div>
            <div onClick={nextBtnAction} className="next w-25 h-full absolute top-0 right-0 cursor-pointer"></div>
            <Sliders
                slidersRefs={slidersRefs}
                person={person}
                currentSlider={currentSlider}
            />
            <div className="flex items-center justify-between px-3">
                <div className="flex gap-3 items-center">
                    <div className="flex gap-2 items-center">
                        <img className="avatar-story rounded-full aspect-square w-9 h-9" src={person.user.avatar} alt="img"/>
                        <p className="username-story text-lg font-semibold text-gray-300">{person.user.firstName} {person.user.lastName}</p>
                    </div>
                    <p className="time-story text-md font-semibold text-gray-400">{calculateSinceDate(sinceDate)}</p>
                </div>
                <p onClick={closeStory} className="close-story text-3xl cursor-pointer text-gray-50 z-2">×</p>
            </div>
            <img className="story-img h-full w-full absolute top-0 bottom-0 left-0 right-0 object-cover z-[-1]" src={person.slides[currentSlider].image} alt="img"/>
            {containerLocation !== "" && (
                <div className="absolute flex items-center justify-center gap-1 py-[5px] px-[10px] rounded-[7px] text-[18px] bg-white font-bold h-fit w-fit top-[75%] left-[75%]">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#804a9d">
                            <path d="M480.26-483q32.74 0 55.24-22.26 22.5-22.25 22.5-55 0-32.74-22.46-55.24-22.47-22.5-55.5-22.5Q447-638 425-615.54q-22 22.47-22 55.5Q403-527 425.26-505q22.25 22 55 22ZM480-179q128-115 189.5-204T731-555q0-112.52-72.64-184.26T480.15-811q-105.57 0-178.36 71.74Q229-667.52 229-555q0 83 63 171.5T480-179Zm0 124Q307-199 221-318.5T135-555q0-159.72 104.04-255.36Q343.08-906 480-906q136.49 0 241.25 95.64Q826-714.72 826-555q0 117-86.5 236.5T480-55Zm0-505Z"></path>
                        </svg>
                    </div>
                    <p className="bg-gradient-to-r from-[#804a9d] to-[#515cae] bg-clip-text text-transparent">{containerLocation}</p>
                </div>
            )}
        </div>
    );
};

export default Story;