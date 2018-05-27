<template>

      <div>
         <h2>Articles</h2>

         <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target=".bd-example-modal-lg" @click="clearArticle()">Add</button>

         <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-centered">
                 <div class="modal-content">
                     <form @submit.prevent="addArticle" class="mb-3">
                           <div class="form-group modal-header">
                              <input type="text" class="form-control" placeholder="Title" v-model="article.title">
                           </div>
                     
                           <div class="form-group modal-body">
                                 <textarea type="text" class="form-control" placeholder="Body" v-model="article.body"></textarea>
                           </div>
                     
                           <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" type="submit">Save</button>
                           </div>

                        </form>
                 </div>
               </div>
             </div>


             
      
         
      
      
         <nav aria-label="Page navigation example">
               <ul class="pagination">
                 <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                  <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page}}</a></li>
                 <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a></li>
               </ul>
             </nav>
      
         
         <!-- <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3>{{ article.title }}</h3>
            <p> {{ article.body }} </p>
            <hr>
            <button @click="editArticle(article)"class="btn btn-warning mb-2" data-toggle="modal" data-target=".bd-example-modal-lg">Edit</button>
            
            <button @click="deleteArticle(article.id)"class="btn btn-danger">Delete</button>
            
         </div> -->

         <div class="row">
               <div class="col-md-4" v-for="article in articles" @click="editArticle(article)"  data-toggle="modal" data-target=".bd-example-modal-lg" v-bind:key="article.id">
           
                 <div class="card mb-4 box-shadow">
                   <div class="card-body">
                        <h5 class="card-title">{{ article.title }}</h5>
                     <p class="card-text">{{ article.body }}</p>
                     <div class="d-flex justify-content-between align-items-center">
                       <div class="btn-group">
                         <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                         <button @click="deleteArticle(article.id)" type="button" class="btn btn-sm btn-outline-secondary">Delete</button>
                       </div>
                       <small class="text-muted">9 mins</small>
                     </div>
                   </div>
                 </div>
               </div>
         </div>
      
         
                  
             
         
      
      </div>
      
      </template>
      
      <script>
         export default {
            data() {
               return {
                  articles: [],
                  article: {
                     id: '',
                     title: '',
                     body: ''
                  },
                  article_id: '',
                  pagination: {},
                  edit: false
               }
            },
      
            created() {
               this.fetchArticles();
            },
      
            methods: {
               fetchArticles(page_url){
                  let vm = this;
                  page_url = page_url || 'api/articles'
                  fetch(page_url)
                  .then(res => res.json())
                  .then(res => {
                     this.articles = res.data;
                     vm.makePagination(res.meta, res.links);
                  })
                  .catch(err => console.log(err));
               },
      
               makePagination(meta, links) {
                  let pagination = {
                     current_page: meta.current_page,
                     last_page: meta.last_page,
                     next_page_url: links.next,
                     prev_page_url: links.prev
                  }
      
                   this.pagination = pagination;
               },
      
               deleteArticle(id){
      
                  if(confirm('Are you Sure?')){
                     fetch(`api/article/${id}`, {
                        method: 'delete'
                     })
                     .then(res => res.json())
                     .then(data => {
                        // alert('Article Removed');
                        this.fetchArticles();
                     })
                     .catch(err => console.log(err));
                  }
               },
               clearArticle(){
                  this.article.id = '';
                  this.article.article_id = '';
                  this.article.title = '';
                  this.article.body = '';
               },
      
               addArticle() {
                  if (this.edit == false){
                     
                     // Add
                     fetch('api/article',{
                        method: 'post',
                        body: JSON.stringify(this.article),
                        headers:{
                           'content-type': 'application/json'
                        }
                     })
                     .then(res =>res.json())
                     .then(data =>{
                        
                        this.article.title='';
                        this.article.body='';
                        // alert('Article Added');
                        this.fetchArticles();
                     })
                     .catch(err => console.log(err));
                     
                  }
                  else{
                     // Update
                     
                     fetch('api/article',{
                        method: 'put',
                        body: JSON.stringify(this.article),
                        headers:{
                           'content-type': 'application/json'
                        }
                     })
                     .then(res =>res.json())
                     .then(data =>{
                     
                        this.article.title='';
                        this.article.body='';
                        // alert('Article Updated');
                        this.fetchArticles();
                     })
                     .catch(err => console.log(err));
                     this.edit = false;
                     this.article.id = '';
                     this.article.article_id = '';
                     this.article.title = '';
                     this.article.body = '';

                     
      
                  }
                  
               },
      
               editArticle(article) {
                  this.edit = true;
                  this.article.id = article.id;
                  this.article.article_id = article.id;
                  this.article.title = article.title;
                  this.article.body = article.body;
               }
               
              
            }
      
         }

         
         

      // $("document").ready(function(){

      //    $('.card-body').on('click', function(){
      //       $( "button:first" ).trigger( "click" );
                
      //    });

      // });




      </script>