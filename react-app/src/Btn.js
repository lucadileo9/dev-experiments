// function Btn() {
//     const clickHandler = () => {
//         console.log('Button clicked');
//     }
//     return (
//         <button onClick={clickHandler}>Click me</button>
//     )
// }

// export default Btn;

function Btn() {

    function thirdExample() {
        console.log('third example');
    };
    const fourthExample = () => console.log('fourth example');

return (
    <>
    <button onClick={function() {console.log('first example')}}>
        An inline anonymous ES5 function event handler
    </button>
    <button onClick={() => console.log('second example')}>
        An inline anonymous ES6 function event handler
    </button>
    <button onClick={thirdExample}>
        using a separate function declaration
     </button>
     <button onClick={fourthExample}>
        using a separate function expression
     </button>

    </>
    )
}

export default Btn;