(function(){
    // @ts-ignore
    igk.system.createNS('igk.jobs', {
        treat(){    
            const o = [];
            // @ts-ignore
            $igk('h2').each_all(function(){ o.push(this.o.innerHTML.trim()); });
            console.log(JSON.stringify(o));
        }
    });
})();