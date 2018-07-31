const admin = require('firebase-admin');
const serviceAccount = require('./ServiceAccountKey.json');

admin.initializeApp({
   credential: admin.credential.cert(serviceAccount)
})

const theCollection = 'allitems'

const db = admin.firestore();

 var citiesRef = db.collection(theCollection);
 var allCities = citiesRef.get()
     .then(snapshot => {
       snapshot.forEach(doc => {
         console.log(doc.id, '=>', doc.data());
         db.collection(theCollection).doc(doc.id).delete();

       });
     })
     .catch(err => {
       console.log('Error getting documents', err);
     });          
