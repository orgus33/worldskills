let interval;
let currentSlider = 0


const fetchJson = async () => {
    const response = await fetch("people.json");
    return await response.json();
}

const body = document.querySelector("body");
const story = document.querySelector(".story");

const closeStory = (interval) => {
    clearInterval(interval);
    body.classList.remove("overflow-hidden");
    story.classList.add("hidden")
    currentSlider = 0;
    story.querySelector(".container-location").remove();
}

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

const animateSliders = (sliders, people, currentSlider) => {
    const timeStory = story.querySelector(".time-story");
    const slidesContainer = story.querySelector(".slides");
    const storyImg = story.querySelector(".story-img");
    let storyDuration = typeof people.slides[currentSlider].duration !== "undefined" ? people.slides[currentSlider].duration * 1000 : 5000

    story.querySelector(".container-location")?.remove();

    if (typeof people.slides[currentSlider].location !== "undefined") {
        const containerLocation = document.createElement("div");
        containerLocation.className = "container-location absolute flex items-center justify-center gap-1 py-[5px] px-[10px] rounded-[7px] text-[18px] bg-white font-bold h-fit w-fit"
        containerLocation.classList.add("top-[" + people.slides[currentSlider].location.y + "%]")
        containerLocation.classList.add("left-[" + people.slides[currentSlider].location.x + "%]")

        const imageLocation = document.createElement("div");
        imageLocation.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 -960 960 960\" width=\"24px\" fill=\"#804a9d\">\n" +
            "            <path d=\"M480.26-483q32.74 0 55.24-22.26 22.5-22.25 22.5-55 0-32.74-22.46-55.24-22.47-22.5-55.5-22.5Q447-638 425-615.54q-22 22.47-22 55.5Q403-527 425.26-505q22.25 22 55 22ZM480-179q128-115 189.5-204T731-555q0-112.52-72.64-184.26T480.15-811q-105.57 0-178.36 71.74Q229-667.52 229-555q0 83 63 171.5T480-179Zm0 124Q307-199 221-318.5T135-555q0-159.72 104.04-255.36Q343.08-906 480-906q136.49 0 241.25 95.64Q826-714.72 826-555q0 117-86.5 236.5T480-55Zm0-505Z\"/>\n" +
            "        </svg>"

        containerLocation.appendChild(imageLocation);

        const textLocation = document.createElement("p");
        textLocation.className = "bg-gradient-to-r from-[#804a9d] to-[#515cae] bg-clip-text text-transparent"
        textLocation.innerText = people.slides[currentSlider].location.text

        containerLocation.appendChild(textLocation);

        story.append(containerLocation);
    }

    // S'assurer que tous les sliders sont à jour
    console.log("currentSlider", currentSlider)
    if (currentSlider > 0) {
        sliders.forEach((slide, index) => {

            if (index <= currentSlider) {
                slide.style.width = "100%"
            }
        })
    }

    timeStory.innerText = calculateSinceDate(people.slides[currentSlider].date)

    sliders[currentSlider].animate([
        {width: "0"},
        {width: "100%"},
    ], {
        duration: storyDuration,
        iterations: 1,
        fill: "forwards"
    })

    interval = setInterval(() => {

        const slider = sliders[currentSlider];
        const parent = slider.parentElement;
        const widthPx = parseFloat(getComputedStyle(slider).width);
        const parentWidthPx = parseFloat(getComputedStyle(parent).width);
        const widthPercent = (widthPx / parentWidthPx) * 100;

        if (widthPercent === 100 && currentSlider < slidesContainer.children.length - 1) {
            currentSlider++;

            storyDuration = typeof people.slides[currentSlider].duration !== "undefined" ? people.slides[currentSlider].duration * 1000 : 5000
            timeStory.innerText = calculateSinceDate(people.slides[currentSlider].date)

            story.querySelector(".container-location")?.remove();

            if (typeof people.slides[currentSlider].location !== "undefined") {
                const containerLocation = document.createElement("div");
                containerLocation.className = "container-location absolute flex items-center justify-center gap-1 py-[5px] px-[10px] rounded-[7px] text-[18px] bg-white font-bold h-fit w-fit"
                containerLocation.classList.add("top-[" + people.slides[currentSlider].location.y + "%]")
                containerLocation.classList.add("left-[" + people.slides[currentSlider].location.x + "%]")

                const imageLocation = document.createElement("div");
                imageLocation.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 -960 960 960\" width=\"24px\" fill=\"#804a9d\">\n" +
                    "            <path d=\"M480.26-483q32.74 0 55.24-22.26 22.5-22.25 22.5-55 0-32.74-22.46-55.24-22.47-22.5-55.5-22.5Q447-638 425-615.54q-22 22.47-22 55.5Q403-527 425.26-505q22.25 22 55 22ZM480-179q128-115 189.5-204T731-555q0-112.52-72.64-184.26T480.15-811q-105.57 0-178.36 71.74Q229-667.52 229-555q0 83 63 171.5T480-179Zm0 124Q307-199 221-318.5T135-555q0-159.72 104.04-255.36Q343.08-906 480-906q136.49 0 241.25 95.64Q826-714.72 826-555q0 117-86.5 236.5T480-55Zm0-505Z\"/>\n" +
                    "        </svg>"

                containerLocation.appendChild(imageLocation);

                const textLocation = document.createElement("p");
                textLocation.className = "bg-gradient-to-r from-[#804a9d] to-[#515cae] bg-clip-text text-transparent"
                textLocation.innerText = people.slides[currentSlider].location.text

                containerLocation.appendChild(textLocation);

                story.append(containerLocation);
            }

            sliders[currentSlider].animate([
                {width: "0"},
                {width: "100%"},
            ], {
                duration: storyDuration,
                iterations: 1,
                fill: "forwards"
            })

        } else if (widthPercent === 100 && currentSlider === slidesContainer.children.length - 1) {
            clearInterval(interval);
            closeStory();
        }

        storyImg.src = people.slides[currentSlider].image
    }, 200)

}

const openStory = (people) => {
    const avatarStory = story.querySelector(".avatar-story");
    const usernameStory = story.querySelector(".username-story");
    const closeStoryBtn = story.querySelector(".close-story");
    const slidesContainer = story.querySelector(".slides");
    const prevBtn = story.querySelector(".prev");
    const nextBtn = story.querySelector(".next");

    avatarStory.src = people.user.avatar;
    usernameStory.innerText = people.user.firstName + " " + people.user.lastName;

    closeStoryBtn.addEventListener("click", () => closeStory(interval));


    // gestion des sliders
    slidesContainer.innerHTML = "";

    people.slides.forEach((slide, i) => {
        const slideContainer = document.createElement("div");
        slideContainer.className = "h-1 rounded-xl w-full bg-gray-400 relative overflow-hidden"
        slideContainer.id = i;

        const progressBar = document.createElement("div");
        progressBar.className = "progress-bar rounded-xl absolute left-0 top-0 bottom-0 bg-gray-50"

        slideContainer.appendChild(progressBar);
        slidesContainer.append(slideContainer);
    })


    const sliders = story.querySelectorAll(".progress-bar")
    animateSliders(sliders, people, currentSlider)

    prevBtn.addEventListener("click", () => {
        clearInterval(interval);

        if (currentSlider === 0) {
            animateSliders(sliders, people, currentSlider)
        } else {
            currentSlider--;
            animateSliders(sliders, people, currentSlider)
        }
    });

    nextBtn.addEventListener("click", () => {
        clearInterval(interval);

        console.log(currentSlider)
        console.log(slidesContainer.children.length - 1)

        if (currentSlider === slidesContainer.children.length - 1) {
            closeStory()
        } else {
            currentSlider++;
            animateSliders(sliders, people, currentSlider)
        }
    })


    body.classList.add("overflow-hidden");
    story.classList.remove("hidden")

}


document.addEventListener("DOMContentLoaded", async () => {

    // Initialiser le front
    const people = await fetchJson();

    const peopleContainer = document.querySelector(".people-container");

    people.forEach(person => {
        const container = document.createElement("div");
        container.className = "avatar relative hover:scale-125 duration-200";

        const img = document.createElement("img");
        img.className = "object-cover rounded-full overflow-hidden border-5 border-gray-200 cursor-pointer hover:border-gray-500  ";
        img.src = person.user.avatar

        container.appendChild(img);

        peopleContainer.append(container)

        container.addEventListener("click", () => openStory(person))
    })


})


