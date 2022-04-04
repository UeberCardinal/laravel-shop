
$(document).ready(function () {
    let checkboxNames = ['hit', 'new', 'recommend']
    checkboxNames.forEach(function (checkboxName){
        $(`#${checkboxName}`).change(function () {
            if (this.checked) {
                const value = $(`input.${checkboxName}`).val()
                $('#submit').trigger('click')
                console.log(checkboxName)
                $.ajax({
                    method: "GET",
                    url: "{{route('home.index')}}",
                    data: {checkbox: value},
                })
            }
            if (!this.checked) {
                const hit = ""
                $('#submit').trigger('click')
                $.ajax({
                    method: "GET",
                    url: "{{route('home.index')}}",
                    data: {checkbox: hit},
                })
            }
    })

    })
})


