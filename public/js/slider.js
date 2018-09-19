$(document).ready(function(){
    s = new slider("#gallery");
});

var slider  = function (id) {
    let self = this;//*on cree un variable intermediaire self contenant this afin de pouvoir utiliser individuellement chaque element de l'id*//
    this.div = $(id); //*on recupere la div concernant l'element sur lequel on travaille (id = "#gallery)*//
    this.slider=this.div.find(".slider");

    this.largeurDiv = this.div.width();//*on calcul la largeur de la div en la mettant dans une variable*//
    this.largeur=0;
    this.div.find('a').each((function(){//*on cherche dans la div chaque element 'a' qui represente element image dans notre code*/
        self.largeur+=$(this).width();//*puis on ajoute la largeur de chaque element chaque fois que l'on trouve un element 'a'*/
        self.largeur+=parseInt($(this).css("padding-left"));//*on ajoute le cadre de nos image en recuperant la valeur "css" des padding et margin l'entourant en parsant sur int pour enlever 'px'*/
        self.largeur+=parseInt($(this).css("padding-right"));
        self.largeur+=parseInt($(this).css("margin-left"));
        self.largeur+=parseInt($(this).css("margin-right"));
    }));


    this.precedent = this.div.find(".precedent");
    this.suivant = this.div.find(".suivant");
    this.pas = this.largeurDiv/1.15;
    this.nbPas = Math.ceil(this.largeur/this.pas - this.largeurDiv/this.pas);
    this.courant=0;


    this.suivant.click(function(){
        if(self.courant<=self.nbPas) {
            self.courant++;
            self.slider.animate({
                left: -self.courant * self.pas
            }, 1000);
        }
    });

    this.precedent.click(function(){
        if(self.courant>0) {
            self.courant--;
            self.slider.animate({
                left: -self.courant * self.pas
            }, 1000);
        }
    });
};



