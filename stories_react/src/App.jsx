import {useEffect, useRef, useState} from 'react'
import Story from "./components/Story.jsx";

function App() {

    const [people, setPeople] = useState(null)
    const [storyPerson, setStoryPerson] = useState(null)
    const [sliders, setSliders] = useState(null)
    const slidersRefs = useRef([]);

    const fetchJson = async () => {
        const response = await fetch("people.json");
        return await response.json();
    }

    useEffect(() => {
        setPeople(fetchJson())


    }, []);

    // Add Listener on btn
    prevBtn.addEventListener("click", () => {
        if (currentSlider > 0) {
            currentSlider--;
        }
        animateSliders()
    });

    nextBtn.addEventListener("click", () => {
        currentSlider++;
        animateSliders()
    })

    closeStoryBtn.addEventListener("click", () => closeStory());

    const openStory = (person) => {
        setStoryPerson(person);
    }

    return (
        <>
            {people && people.forEach(person => (
                <div className="avatar relative hover:scale-125 duration-200" onClick={() => openStory(people)}>
                    <img src={person.user.avatar} className="object-cover rounded-full overflow-hidden border-5 border-gray-200 cursor-pointer hover:border-gray-500" alt=""/>

                    {storyPerson === person && <Story person={person} slidersRefs={slidersRefs}/>}
                </div>
            ))}
        </>
    )
}

export default App
