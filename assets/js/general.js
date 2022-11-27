const GITHUB_API_URL = "https://api.github.com/";

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

const searchGithubForUser = async (username) => {
    const SEARCH_URL = `${GITHUB_API_URL}search/users?q=${username} in:login`;
    const response = await fetch(SEARCH_URL);
    const data = await response.json();
    return data;
}