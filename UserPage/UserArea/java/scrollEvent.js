function scrollEvent (targetElement, i) {
    const element = document.getElementsByClassName(targetElement);

    element[i].scrollIntoView( { behavior: "smooth" } );
}