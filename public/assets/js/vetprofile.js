// vetProfile.js

const vetData = {
    username: "johndoe",
    email: "johndoe@example.com",
    password: "********",
    createdDate: "2024-11-12",
    licenseNo: "123456",
    firstName: "John",
    lastName: "Doe",
    age: 35,
    gender: "Male",
    district: "Downtown",
    city: "Metropolis",
    contactNo: "+123456789",
    yearsOfExperience: 10,
    profilePicture: "../assets/images/default-profile-picture.webp"
  };
  
  document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("username").innerText = vetData.username;
    document.getElementById("email").innerText = vetData.email;
    document.getElementById("password").innerText = vetData.password;
    document.getElementById("createdDate").innerText = vetData.createdDate;
    document.getElementById("licenseNo").innerText = vetData.licenseNo;
    document.getElementById("firstName").innerText = vetData.firstName;
    document.getElementById("lastName").innerText = vetData.lastName;
    document.getElementById("age").innerText = vetData.age;
    document.getElementById("gender").innerText = vetData.gender;
    document.getElementById("district").innerText = vetData.district;
    document.getElementById("city").innerText = vetData.city;
    document.getElementById("contactNo").innerText = vetData.contactNo;
    document.getElementById("yearsOfExperience").innerText = vetData.yearsOfExperience;
    document.getElementById("profilePicture").src = vetData.profilePicture;
  });
  