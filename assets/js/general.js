const showAlertBox = (message, type) => {
    const alertBox = document.createElement('div');
    alertBox.classList.add('alert-box');
    alertBox.classList.add(type);
    alertBox.innerText = message;
    document.body.appendChild(alertBox);
    alertBox.classList.add('show');

    setTimeout(() => {
        alertBox.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(alertBox);
        }, 1000);
    }, 3000);
}