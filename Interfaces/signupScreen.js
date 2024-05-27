var niveauMentionInfo = {
    "License 1": {
        "Tronc commun":''
    },
    "License 2": {
        "Génie Electrique & Techno":'',
        "Génie Mécanique":'',
        "Génie Civile":''
    },
    "License 3": {
        "Electronique & Informatique":'',
        "Génie Electrique":'',
        "Génie Mécanique":'',
        "Hydrolyque & Energetique":'',
        "Génie Civile (BTP)":'',
        "Génie Civile (BAT)":''
    }, 
    "Master 1": {
        "S.T.I.C":'',
        "Génie Electrique":'',
        "Génie Mécanique":'',
        "Hydrolyque & Energetique":'',
        "Génie Mécatronique":'',
        "Génie Civile (BTP)":'',
        "Génie Civile (BAT)":''
    },
    "Master 2": {
        "S.T.I.C":'',
        "Génie Electrique":'',
        "Génie Mécanique":'',
        "Hydrolyque & Energetique":'',
        "Génie Mécatronique":'',
        "Génie Civile (BTP)":'',
        "Génie Civile (BAT)":''
    }
}

window.onload = function(){
    const selectNiveau = document.getElementById('selectNiveau'),
    selectMention = document.getElementById('selectMention'), selects = document.querySelectorAll('select')

    selectMention.disabled = true

    selects.forEach(select => {
        if (select.disabled == true) {
            select.style.cursor = "auto"
        }
    })

    for (let niveau in niveauMentionInfo) {
        selectNiveau.options[selectNiveau.options.length] = new Option (niveau, niveau)
    }

    selectNiveau.onchange = (e) => {
        selectMention.disabled = false
        selectMention.length = 1

        for (let mention in niveauMentionInfo[e.target.value]) {
            selectMention.options[selectMention.options.length] = new Option(mention, mention)
        }
    }

}