import Sliders from "./Sliders.jsx";
import {useEffect} from "react";

const Story = ({person, slidersRefs}) => {

    useEffect(() => {
        document.body.classList.add("overflow-hidden");
    }, []);


    return (
        <>
            <div className="story absolute top-0 left-0 bottom-0 right-0 bg-gray-800 px-2 py-3 z-1">
                <div className="prev w-25 h-full absolute top-0 left-0 cursor-pointer"></div>
                <div className="next w-25 h-full absolute top-0 right-0 cursor-pointer"></div>

                <Sliders slidersRefs={slidersRefs}/>

                <div className="flex items-center justify-between px-3">
                    <div className="flex gap-3 items-center">

                        <div className="flex gap-2 items-center">
                            <img className="avatar-story rounded-full aspect-square w-9 h-9" src={person.user.avatar} alt="img"/>
                            <p className="username-story text-lg font-semibold text-gray-300">person.user.firstName + " " + person.user.lastName</p>
                        </div>

                        <p className="time-story text-md font-semibold text-gray-400">2 d</p>
                    </div>

                    <p className="close-story text-3xl cursor-pointer text-gray-50 z-2">×</p>
                </div>


                <img className="story-img h-full w-full absolute top-0 bottom-0 left-0 right-0 object-cover z-[-1]" src="https://picsum.photos/id/3/500/900" alt="img"/>

            </div>


        </>
    )
}

export default Story;