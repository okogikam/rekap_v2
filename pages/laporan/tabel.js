class tabel{
    constructor(config){
        this.label = config.label;
        this.data = config.data;
        this.tabel = config.tabel;
    }
    createHeadTable(){
        let thead = this.tabel.querySelector("thead");
        let tr = document.createElement("tr");
        this.label.forEach(el => {
            let th = document.createElement("th");
            th.innerHTML = `${el}`;
            tr.appendChild(th);
        });
        thead.appendChild(tr);
    }
    init(){
        this.createHeadTable();
    }
}