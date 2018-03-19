const $ = require("jquery");
let last_loaded_snippet;

function editor_setup(id) {
    const e = ace.edit(id);
    const local_storage_code = localStorage.getItem("pewRunner.code");
    let code_on_load = $("#initial-code").val();

    if (local_storage_code !== null) {
        code_on_load = local_storage_code;
    }

    e.session.setMode("ace/mode/php");
    e.setTheme("ace/theme/pew");
    e.setValue(code_on_load);

    e.setOptions({
        enableBasicAutocompletion: true
    });

    e.commands.addCommand({
        name: "run-code",
        bindKey: {win: "Ctrl-Enter", mac: "Command-Enter"},
        exec: function (e) {
            snippet_run();
        }
    });

    return e;
}

function editor_focus() {
    editor.focus();
    editor.navigateFileEnd();
}

function snippet_run() {
    const code = editor.getValue();
    localStorage.setItem("pewRunner.code", code);

    $.post("/run", {code}, function (response) {
        $("#output").html(response);
    });
}

function snippet_save(title) {
    const code = editor.getValue();

    $.post("/save", {title, code}, function (response) {
        if (response.is_new) {
            const $link = $(`<div class="snippet">
                <a href="#" class="load" data-name="${response.name}">${response.title}</a>
                <a href="#" class="delete" data-name="${response.name}">&times;</a>
            </div>`);
            $("#load-snippet").append($link);
        }
    });
}

function snippet_load(name, callback) {
    $.getJSON(`/load/${name}`, function (response) {
        last_loaded_snippet = response.title;
        editor.setValue(response.code);
        localStorage.setItem("pewRunner.code", response.code);

        callback();
    });
}

function snippet_delete(name, callback) {
    $.post("/delete", {name}, function (response) {
        callback();
    });
}

function package_install(packageName) {
    $("#overlay").removeClass("hidden");

    $.post("/install", {packageName}, function (response) {
        $("#package-list").html(response);
        $("#overlay").addClass("hidden");
    });
}

function package_uninstall(packageName) {
    $("#overlay").removeClass("hidden");

    $.post("/uninstall", {packageName}, function (response) {
        $("#package-list").html(response);
        $("#overlay").addClass("hidden");
    });
}

$("#run, .help").click(function (e) {
    snippet_run();
    editor_focus();

    return false;
});

$("#save-snippet").click(function (e) {
    const title = prompt("Choose a title for the snipperino:", last_loaded_snippet);

    if (title) {
        snippet_save(title);
    }

    editor_focus();
});

$("#load-snippet").on("click", "a.load", function (e) {
    snippet_load($(this).data("name"), editor_focus);

    return false;
});

$("#load-snippet").on("click", "a.delete", function (e) {
    snippet_delete($(this).data("name"), () => {
        $(this).parent().remove();
    });
    editor_focus();

    return false;
});

$("#install").click(function (e) {
    const packageName = prompt("Install package:");

    package_install(packageName);

    return false;
});

$("#package-list").on("click", "a.uninstall", function (e) {
    package_uninstall($(this).data("name"), () => {
        $(this).parent().remove();
    });
    editor_focus();

    return false;
});

const editor = editor_setup("ace-wrapper");

editor_focus();
