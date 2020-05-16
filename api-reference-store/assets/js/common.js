function appendDataToConsole() {
    for (i = 0; i <= sessionStorage.length - 1; i++) {
        var key = sessionStorage.key(i);
        var val = JSON.parse(sessionStorage.getItem(key));
        $.each(val, function(index, value) {
            console.log(value.functionName);
        });
    }
}

