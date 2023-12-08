function scrollEvent (targetElement) {
    var element = document.getElementsByClassName(targetElement);

    element[0].scrollIntoView( { behavior: "smooth" } );
}