const checkboxes = $("input[type='checkbox']");

checkboxes.each(function () {
    const isChecked = Boolean($(this).data("checked") ?? false);
    if (isChecked) {
        $(this).next().addClass('checked');
        $(this).prop('checked', true);
    }
    $(this).on('change', function () {
        const checkboxLabel = $(this).next();
        checkboxLabel.toggleClass('checked');
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
    indentUnit: 2,
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