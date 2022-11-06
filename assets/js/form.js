const checkboxes = document.querySelectorAll('input[type="checkbox"]');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        const checkboxLabel = checkbox.nextElementSibling;
        checkboxLabel.classList.toggle('checked');
    });
})