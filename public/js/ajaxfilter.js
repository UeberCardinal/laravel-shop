
$(document).ready(function () {
    $('#hit').change(function () {
        if (this.checked) {
            const hit = $('input.hit').val()
            $('#submit').trigger('click')
            $.ajax({
                method: "GET",
                url: "{{route('home.index')}}",
                data: {hit: hit},
            })
        }
        if (!this.checked) {
            const hit = ""
            $('#submit').trigger('click')
            $.ajax({
                method: "GET",
                url: "{{route('home.index')}}",
                data: {hit: hit},
            })
        }
    })

    $('#new').change(function () {
        if (this.checked) {
            const jnew = $('input.new').val()
            $('#submit').trigger('click')
            $.ajax({
                method: "GET",
                url: "{{route('home.index')}}",
                data: {new: jnew},
            })
        }
        if (!this.checked) {
            const jnew = ""
            $('#submit').trigger('click')
            $.ajax({
                method: "GET",
                url: "{{route('home.index')}}",
                data: {new: jnew},
            })
        }
    })

    $('#recommend').change(function () {
        if (this.checked) {
            const recommend = $('input.recommend').val()
            $('#submit').trigger('click')
            $.ajax({
                method: "GET",
                url: "{{route('home.index')}}",
                data: {recommend: recommend},
            })
        }
        if (!this.checked) {
            const recommend = ""
            $('#submit').trigger('click')
            $.ajax({
                method: "GET",
                url: "{{route('home.index')}}",
                data: {recommend: recommend},
            })
        }
    })
})


