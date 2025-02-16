class GAS{
    constructor(conf){
        this.element = conf.element;
        this.id = conf.id;
        this.name = conf.name || "Sheet1";
        this.label = conf.label || [];
        this.ready = false;
        this.dataLoaded = false;
        this.dataShow = conf.dataShow || 4;
        this.editOn = false;
	this.min = 1;
	this.max = this.dataShow;
        this.url = conf.url || "https://script.google.com/macros/s/AKfycbzsCr87ss_uUoORjNwK2lnsmDTwwK9LPwOA5w1M05MgaVNqrrbpbyU6NeqxoIm3uCGB/exec";
    }
    async loadData(){
        let response = await fetch(`${this.url}?id=${this.id}&name=${this.name}`);
        let responseJSON = await response.json();
        this.data = responseJSON.value;
        this.ready = true;
    }
    createTable(){
        if(!this.ready){
            return;
        }
        if(this.dataShow > this.data[0].length){
            this.dataShow = this.data[0].length
        }
        //table head
        let thead = document.createElement("thead");
        let tr = document.createElement("tr");
	tr.innerHTML += `<th>${this.data[0][0]}</th>`;
        if(this.label.length != 0){
		console.log(this.label);
            for(let i =0; i< this.label.length; i++){
                let th = document.createElement("th");
                th.innerHTML = `${this.label[i]}`;
                tr.appendChild(th);
            }
            tr.innerHTML += "<th>Opsi</th>";
            thead.appendChild(tr)
        }else{
            for(let i =1; i< this.dataShow; i++){
                let th = document.createElement("th");
                th.innerHTML = `${this.data[0][i]}`;
                tr.appendChild(th);
            }
            tr.innerHTML += "<th>Opsi</th>";
            thead.appendChild(tr)
        }
        // table body 
        let tbody = document.createElement("tbody");

	if(typeof(this.dataShow) === "object"){
           this.min = Number(this.dataShow[0]);
	   this.max = Number(this.dataShow[1]) + 1;
	}
	
        for(let i = 1; i < this.data.length; i++){
            let tr = document.createElement("tr");
            tr.innerHTML += `<td>${this.timeStamp(this.data[i][0])}</td>`;
            for(let j = this.min; j < this.max; j++){
                let td = document.createElement("td")
                td.innerHTML = `${this.data[i][j]}`;
                tr.appendChild(td)
            }
            tr.innerHTML += `<td><button class="btn btn-success info"><i class="nav-icon fas fa-info"></i></button></td>`;

            tr.querySelector(".info").addEventListener("click",()=>{
                this.showDetail(this.data[i],i+1)
            })
            tbody.appendChild(tr);
        }
	console.log(this.min)
	console.log(this.max)
        console.log(this.data[this.min][1])

        this.element.appendChild(thead);
        this.element.appendChild(tbody);
        this.dataLoaded = true;
        new DataTable(this.element,{
            destroy: true,
            responsive: true,
            autoWidth: false,
        })
    }

    showDetail(data,row){
        let body = document.querySelector("body");
        let modal = document.createElement("div");
        let modalContent = document.createElement("div");
        modal.setAttribute("id","modal");
        modalContent.setAttribute("class","card modal-content");
        // modal head 
        let modalHeder = document.createElement("div");
        modalHeder.classList.add("modal-header");
        modalHeder.innerHTML = `
        <h4 class="modal-title"><small class="brand-text font-weight-light">${this.timeStamp(data[0])}</small></h4>
        <span class="floaf-right">
        <label>Edit On </label>
        <button type="button" class="edit btn btn-sm btn-primary" ><i class="fas fa-pen-fancy"></i></button>        
        </span>
        `
        //modal body
        let modalBody = document.createElement("div");
        modalBody.classList.add("modal-body");
        modalBody.innerHTML = `
        <input class="form-control d-none" value="${data[0]}" disabled>
        `
        for(let i = 1; i < data.length; i++){
            let div = document.createElement("div");
            div.innerHTML = `
            <label>${this.data[0][i]}</label>
            <input class="form-control" value="${this.dataValue(data[i])}" disabled>
            `
           
            modalBody.appendChild(div)
        }
        // modal footer
        let modalFooter = document.createElement("div");
        modalFooter.classList.add("modal-footer")
        modalFooter.innerHTML = `
        <button type="button" class="btn btn-default mdl-close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save">Save changes <span class="status"></span></button>`

        modalContent.appendChild(modalHeder);
        modalContent.appendChild(modalBody);
        modalContent.appendChild(modalFooter);
        modal.appendChild(modalContent);
        body.appendChild(modal);
        modal.querySelector(".mdl-close").addEventListener("click",()=>{
            this.editOn = false;
            modal.remove();
        })
        modal.querySelector(".save").addEventListener("click",()=>{
            let status = modalFooter.querySelector(".status");
            status.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
            this.updateData({
                data: modalBody.querySelectorAll("input"),
                row: row,
                status: status
            })
        })
        modal.querySelector(".edit").addEventListener("click",()=>{
            let form = modalBody.querySelectorAll("input");
            if(this.editOn){
                modalHeder.querySelector("label").innerHTML = "Edit On"
                this.editOn = false;
                this.editOnOff(form)
            }else{
                modalHeder.querySelector("label").innerHTML = "Edit Off"
                this.editOn = true;
                this.editOnOff(form)
            }
        })
    }
   async updateData(conf){
        let data = [];
        for(let i = 0; i < conf.data.length; i++){
            data.push(conf.data[i].value);
        }
        let dataString = JSON.stringify(data);
        let result = await fetch(`${this.url}?id=${this.id}&name=${this.name}&data=${dataString}&type=update&row=${conf.row}`)
        let resultData = await result.json();
        if(resultData){
            conf.status.innerHTML = `<i class="fas fa-check"></i>`
        }
        // console.log(dataString)
    }
    async uploadData(conf){
        let data = [];
        for(let i = 0; i < conf.data.length; i++){
            data.push(conf.data[i].value);
            // console.log(conf.data[i].value);
        }
        let dataString = JSON.stringify(data);
        let result = await fetch(`${this.url}?id=${this.id}&name=${this.name}&data=${dataString}&type=upload&row=${conf.row}`)
        let resultData = await result.json();
        if(resultData){
            conf.status.innerHTML = `<i class="fas fa-check"></i>`
        }
    }
    editOnOff(form){
        if(this.editOn){
            form.forEach(input => {
                input.removeAttribute("disabled")         
            })
        }else{
            form.forEach(input => {
                input.setAttribute("disabled","")                
            })
        }
    }
    timeStamp(time){
        let ts = time.split("T");
	    return ts[0];
    }
    dataValue(data){
        // let d = new Date(data)? new Date(data) : data;
        // if(d != "Invalid Date"){
        //     return d;
        // }
        return data;
    }
    addData(){
        let body = document.querySelector("body");
        let modal = document.createElement("div");
        let modalContent = document.createElement("div");
        modal.setAttribute("id","modal");
        modalContent.setAttribute("class","card modal-content");
        // modal head 
        let modalHeder = document.createElement("div");
        modalHeder.classList.add("modal-header");
        modalHeder.innerHTML = `
        <h4 class="modal-title"><small class="brand-text font-weight-light">Add data</small></h4>
        `
        //modal body
        let modalBody = document.createElement("div");
        modalBody.classList.add("modal-body");
        for(let i = 0; i < this.data[0].length; i++){
            let div = document.createElement("div");
            div.innerHTML = `
            <label>${this.data[0][i]}</label>
            <input class="form-control" value="">
            `
           
            modalBody.appendChild(div)
        }
        // modal footer
        let modalFooter = document.createElement("div");
        modalFooter.classList.add("modal-footer")
        modalFooter.innerHTML = `
        <button type="button" class="btn btn-default mdl-close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save">Save changes <span class="status"></span></button>`

        modalContent.appendChild(modalHeder);
        modalContent.appendChild(modalBody);
        modalContent.appendChild(modalFooter);
        modal.appendChild(modalContent);
        body.appendChild(modal);

        modal.querySelector(".mdl-close").addEventListener("click",()=>{
            this.editOn = false;
            modal.remove();
        })
        modal.querySelector(".save").addEventListener("click",()=>{
            let status = modalFooter.querySelector(".status");
            status.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
            this.uploadData({
                data: modalBody.querySelectorAll("input"),
                status: status,
		row: this.data.length
            })
        })
    }
    async init(){
        this.element.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
        await this.loadData();

        if(this.ready){
            this.element.innerHTML = ""
            this.createTable();
        }
        // console.log(this.data)
        requestAnimationFrame(()=>{
            if(!this.dataLoaded){
                this.init();
            }
        })
    }

}