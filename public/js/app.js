
//local
//const driver = neo4j.driver("bolt://localhost:7687", neo4j.auth.basic("neo4j", "recommendations"));

//remote
const driver = neo4j.driver("neo4j+s://0aa436aa.databases.neo4j.io", neo4j.auth.basic("neo4j", "AoFLWSx1iZz4-pI8U2jbj6GhyrnEwYUpYQLlSVh1Fj8"));


const session = driver.session({defaultAccessMode: neo4j.WRITE });

try {
    driver.verifyConnectivity()
    console.log('Driver created')
} catch (error) {
    console.log(`connectivity verification failed. ${error}`)
}

//
// try{
//     session.run("match(movie:Movie) return movie limit 2").then(result => {
//         result.records.forEach(record => { console.log(record.get('movie').properties.poster)})
//     });
// }catch (e) {
//     console.log(e);
// }
//


// Getting elements
const inputBox = document.querySelector('.navbar-form-search');
const suggBox = document.querySelector('.autocom-box');

var data = []

console.log(window.location.hostname + ':' + window.location.port + '/movie/789');

inputBox.onkeyup = (e)=>{
    var userText = e.target.value;


    if(userText)
    {
        console.log(userText);
         session.run("match(movie:Movie) where toLower(movie.title) contains $text return movie {.*, _id:id(movie)} as movie limit 4",{text : userText.toLocaleLowerCase()})
            .then(result => {

                if(result.records.length > 0)
                {
                    result.records.forEach(record => {
                        var title = record.get('movie').title;
                        var year = record.get('movie').year;
                        var id = record.get('movie')._id.low;
                        var poster = record.get('movie').poster
                        var route = '/movie/' + id;

                        data.push('<a href="' + route + '"><li>' + '<img src="' + poster + '"/>' + title + ' (' + year +')' + '</li></a>');
                    });
                }
                else
                {
                    data.push('<li class="notClickable">No records found!!</li>');
                }

            });
        suggBox.classList.add('active');
        inputBox.classList.add('active');

        //console.log(data.join(''));


        suggBox.innerHTML = data.join('');

        data = [];
    }
    else
    {
        suggBox.classList.remove('active');
        inputBox.classList.remove('active');

    }

}

function showSuggestions(list){
    let listData;
    if(!list.length){
        userValue = inputBox.value;
        listData = `<li>${userValue}</li>`;
    }else{
        listData = list.join('');
    }
    suggBox.innerHTML = listData;
}
