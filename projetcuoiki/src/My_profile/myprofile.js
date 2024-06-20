document.getElementById("submitButton").addEventListener("click", function() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("phone").value;
    var gender = document.getElementById("gender").value;
    var birthdate = document.getElementById("birthdate").value;
    var address = document.getElementById("address").value;

    document.getElementById("infoName").innerHTML = name;
    document.getElementById("infoEmail").innerHTML = email;
    document.getElementById("infoPhone").innerHTML = phone;
    document.getElementById("infoGender").innerHTML = gender;
    document.getElementById("infoBirthdate").innerHTML = birthdate;
    document.getElementById("infoAddress").innerHTML = address;

    document.getElementById("profileForm").style.display = "none";
    document.getElementById("profileInfo").style.display = "block";
});

function goBack() {
    window.history.back();
}

document.getElementById("backButton").addEventListener("click", goBack);