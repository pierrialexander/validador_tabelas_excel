function showLoading() {
    console.log('Adicionou o showLoading');
    const div = document.createElement("div");
    div.classList.add("loading", "centralize");

    const label = document.createElement("label");
    label.innerText = "Carregando...";

    div.appendChild(label);

    document.body.appendChild(div);
    document.classList("background-novo");
}

function hideLoading() {

}