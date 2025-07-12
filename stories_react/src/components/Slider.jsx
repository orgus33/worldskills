const Slider = ({slidersRefs}) => {




    return (
        <div className="h-1 rounded-xl w-full bg-gray-400 relative overflow-hidden" id={i} key={i}>
            <div ref={el => slidersRefs.current[i] = el} className="progress-bar rounded-xl absolute left-0 top-0 bottom-0 bg-gray-50" style="width: 0%;"></div>
        </div>
    )
}


export default Slider;