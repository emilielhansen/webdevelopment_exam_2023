// Form validation for signup
function validate(event, callback) {
    const form = event.target;
	console.log(form)
	const validate_error = "rgb(255,0,0)"
	form.querySelectorAll("[data-validate]").forEach(function (element) {
		element.classList.remove("validate_error")
		element.style.border = "none"
	})
	form.querySelectorAll("[data-validate]").forEach(function (element) {
		switch (element.getAttribute("data-validate")) {
			case "str":
				if (element.value.length < parseInt(element.getAttribute("data-min")) ||
					element.value.length > parseInt(element.getAttribute("data-max"))
				) {
					element.classList.add("validate_error")
					element.style.border = `2px solid ${validate_error}`
				}
				break;
			case "int":
				if (! /^\d+$/.test(element.value) ||
					parseInt(element.value) < parseInt(element.getAttribute("data-min")) ||
					parseInt(element.value) > parseInt(element.getAttribute("data-max"))
				) {
					element.classList.add("validate_error")
					element.style.border = `2px solid ${validate_error}`
				}
				break;
			case "email":
				let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if (!re.test(element.value.toLowerCase())) {
					element.classList.add("validate_error")
					element.style.border = `2px solid ${validate_error}`
				}
				break;
			case "regex":
				var regex = new RegExp(element.getAttribute("data-regex"))
				if (!regex.test(element.value)) {
					console.log(element.value)
					console.log("regex error")
					element.classList.add("validate_error")
					element.style.border = `2px solid ${validate_error}`
				}
				break;
			case "match":
				if (element.value != form.querySelector(`[name='${element.getAttribute("data-match-name")}']`).value) {
					element.classList.add("validate_error")
					element.style.border = `2px solid ${validate_error}`
				}
				break;
		}
	})
    if (!form.querySelector(".validate_error")) {
        callback(event); 
        return;
    }

    form.querySelector(".validate_error").focus();

}