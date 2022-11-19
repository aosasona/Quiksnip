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
    mode: lang?.value || lang?.innerText,
    lineWrapping: true,
    theme: 'material-darker',
    showCursorWhenSelecting: true,
    autoCloseBrackets: true,
    matchBrackets: true,
    autoCloseTags: true,
    matchTags: true,
    autoRefresh: true,
    styleActiveLine: true,
    styleActiveSelected: true,
    highlightSelectionMatches: true,
    smartIndent: true,
    spellcheck: true,
    indentUnit: 4,
    readOnly: codeDiv?.dataset?.readonly === 'true' ? "nocursor" : false,
});

lang.addEventListener('change', () => {
    editor.setOption('mode', lang.value)
})

const copyEditorContent = () => {
    const code = editor.getValue()
    navigator.clipboard.writeText(code).then(() => {
        showAlertBox('Copied to clipboard', 'success')
    })
}

const copyText = (text) => {
    navigator.clipboard.writeText(text).then(() => {
        showAlertBox('Copied to clipboard', 'success')
    })
}

// const editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
//     lineNumbers: true,
//     mode: language,
//     matchBrackets: true,
// });