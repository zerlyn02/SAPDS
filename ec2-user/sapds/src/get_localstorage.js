const role = localStorage.getItem('role');
const formData = new FormData();
formData.append('role', role);

if (role === 'guardian') {
    const childName = localStorage.getItem('child-name');
    formData.append('childName', childName);
}

fetch('attendance.php', {
    method: 'POST',
    body: formData
})
.then(response => response.text())
.then(data => console.log(data));
