
function myFunction() {
  var data = document.getElementById("worldMap");
  const Countries = data.querySelectorAll(".otan");
  console.log(Countries)
  data.addEventListener("click", function (e)
  {
    var province = e.target.parentNode;
    const NatoCountries = ["si",'mk','me','us','gb','tr','es','sk','ro','pt',
        'no','lu','lt','lv','it','is','hu','pl', 'de', 'nc','al','be','bg','ca','hr','cz','dk','ee','fr','gr','nl']

    console.log(NatoCountries.includes(province.getAttribute("id")))
    if (NatoCountries.includes(province.getAttribute("id")))
    {
      var _id = province.id
      console.log(_id)
      var data = document.querySelectorAll("." + _id);
      if (document.querySelectorAll(".CHOSEN"))
      {
        document.querySelectorAll(".CHOSEN").forEach(function (e)
        {e.classList.remove("CHOSEN")})
      }


      data.forEach(function (e){
        e.classList.add("CHOSEN");
        console.log("diala")
      })
      console.log(document.querySelectorAll('.CHOSEN'))
      document.getElementById("CountryData").textContent = "Country nr:" + _id;


    }

  })
}

function HeatMap()  {
  console.log("heatmapa!")
  var NatoCountries = document.querySelectorAll(".si,.mk,.me,.us,.gb,.tr,.es,.sk,.ro,.pt,.no,.lu,.lt,.lv,.it,.is,.hu,.pl,.de,.nc,.al,.be,.bg,.ca,.hr,.cz,.dk,.ee,.fr,.gr,.nl")
  var NatoValues = {'no':12,'lu':30,'lt':1,'lv':2,'it':34,'is':23,'hu':1,'pl':23, 'de':4, 'nc':2,'al':2,'be':2,'bg':32,'ca':12,'hr':2,'cz':1,'dk':23,'ee':1,'fr':3,"gr":4,"nl":6}


  const getMax = object => {
  let max = Math.max(...Object.values(object))
  return Object.keys(object).filter(key => object[key]==max)
  }

  const getMin = object => {
    let max = Math.min(...Object.values(object))
    return Object.keys(object).filter(key => object[key]==max)
    }


  var maxValue = getMax(NatoValues)
  var minVakeu = getMin(NatoValues)

  Object.keys(NatoValues).forEach( function (key)
  {
    document.querySelectorAll("." + key).forEach(function (e){
      console.log(key)
      console.log(maxValue)
      console.log("middle" + getMidle)
      if (maxValue.includes(key)){
        e.style.fill = "rgb(0,0,230)"
      }
      else if (minVakeu.includes(key))
      {
        e.style.fill = "rgb(128,128,255)"
      }

    })

  })
// rgb(0,0,230)
//   rgb(26,26,255)
//   rgb(51,51,255)
//   rgb(77,77,255)
//   rgb(128,128,255)

}


