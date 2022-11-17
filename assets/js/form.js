const checkboxes = document.querySelectorAll('input[type="checkbox"]');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        const checkboxLabel = checkbox.nextElementSibling;
        checkboxLabel.classList.toggle('checked');
    });
})

/* CODEMIRROR */
const codeDiv = document.getElementById("editor")
const lang = document.getElementById('language')
let editor = CodeMirror.fromTextArea(codeDiv, {
    lineNumbers: true,
    mode: document.getElementById('language').value,
    lineWrapping: true,
    theme: 'material-darker',
    showCursorWhenSelecting: true,
    spellcheck: true,
    indentUnit: 4,
});

lang.addEventListener('change', () => {
    editor.setOption('mode', lang.value)
})

// const editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
//     lineNumbers: true,
//     mode: language,
//     matchBrackets: true,
// });