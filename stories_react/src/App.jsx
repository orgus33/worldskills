import React, {useEffect, useRef, useState} from 'react';
import Story from "./components/Story.jsx";

function App() {
    const [people, setPeople] = useState(null);
    const [storyPerson, setStoryPerson] = useState(null);
    const slidersRefs = useRef([]);
    const [currentSlider, setCurrentSlider] = useState(0);
    const [containerLocation, setContainerLocation] = useState("");
    const [intervalId, setIntervalId] = useState(null);
    const [isStoryOpen, setIsStoryOpen] = useState(false);


    // fetch the json
    useEffect(() => {
        const fetchJson = async () => {
            const response = await fetch("people.json");
            const responseJson = await response.json();
            setPeople(responseJson);
        };
        fetchJson();
    }, []);

    const prevBtnAction = () => {
        if (currentSlider > 0) {
            setCurrentSlider(() => currentSlider - 1)
        }
    }

    const nextBtnAction = () => {
        if (storyPerson && currentSlider < storyPerson.slides.length - 1) {
            setCurrentSlider(currentSlider + 1);
        } else {
            closeStory()
        }
    };

    const closeStory = () => {
        clearInterval(intervalId);
        setIsStoryOpen(false);
        setStoryPerson(null);
        setCurrentSlider(0);
        setContainerLocation("");
        document.body.style.overflow = "visible";
    };

    const openStory = (person) => {
        slidersRefs.current = [];
        setStoryPerson(person);
        setCurrentSlider(0);
        setIsStoryOpen(true);
        document.body.style.overflow = "hidden";
    };

    return (
        <section className={"px-3 py-4 w-full h-full" + (isStoryOpen ? " overflow-hidden" : "")}>
            <div className="people-container flex gap-4 mb-6">
                {people && people.map((person) => (
                    <React.Fragment key={person.id}>
                        <div className="avatar relative hover:scale-125 duration-200" onClick={() => openStory(person)}>
                            <img src={person.user.avatar} className="object-cover rounded-full overflow-hidden border-5 border-gray-200 cursor-pointer hover:border-gray-500" alt=""/>
                        </div>
                        {storyPerson === person && isStoryOpen && (
                            <Story
                                person={person}
                                slidersRefs={slidersRefs}
                                closeStory={closeStory}
                                containerLocation={containerLocation}
                                setContainerLocation={setContainerLocation}
                                prevBtnAction={prevBtnAction}
                                nextBtnAction={nextBtnAction}
                                intervalId={intervalId}
                                setIntervalId={setIntervalId}
                                currentSlider={currentSlider}
                                setCurrentSlider={setCurrentSlider}
                            />
                        )}
                    </React.Fragment>
                ))}
            </div>
            <div className="flex flex-col gap-4">
                <div className="flex items-center justify-center h-100 w-full bg-gray-200 rounded-lg">
                    Random <br/> Content
                </div>
                <div className="flex items-center justify-center h-100 w-full bg-gray-200 rounded-lg">
                    Random <br/> Content
                </div>
                <div className="flex items-center justify-center h-100 w-full bg-gray-200 rounded-lg">
                    Random <br/> Content
                </div>
            </div>
        </section>
    );
}

export default App
