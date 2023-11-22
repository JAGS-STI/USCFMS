function scrollEvent (targetElement) {
    const element = document.getElementsByClassName(targetElement);

    element[0].scrollIntoView( { behavior: "smooth" } );
}