<template>

      <div>
         <h2>Articles</h2>

         <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target=".bd-example-modal-lg" @click="clearArticle()">Add</button>

         <div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-centered">
                 <div class="modal-content">
                     <form @submit.prevent="addArticle" class="mb-3">
                           <div class="form-group modal-header">
                             <input type="text" class="form-control" placeholder="Title" v-model="article.title">
                           </div>
                     
                           <div class="form-group modal-body">
                                 <code><textarea type="text" class="form-control" placeholder="Body" v-model="article.body"></textarea></code>
                           </div>
                     
                           <div class="modal-footer">
                                 <button @click="stopEditing" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" type="submit">Save</button>
                           </div>

                        </form>
                 </div>
               </div>
             </div>

             <h3> Search </h3>
            <input type="text" v-model= "search" class="form-control mb-4" placeholder="Search for...">
          
               
      
         
      
      
         <nav aria-label="Page navigation example">
               <ul class="pagination">
                 <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                  <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page}}</a></li>
                 <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a></li>
               </ul>
             </nav>
      
         

         <div class="row">
               <div class="col-md-4" v-for="article in filteredArticles" @click="editArticle(article)"   v-bind:key="article.id">
           
                 <div class="card mb-4 box-shadow">
                   <div class="card-body">
                        <h5 class="card-title">{{ article.title }}</h5>
                     <p class="card-text">{{ article.sbody }}</p>
                     <div class="d-flex justify-content-between align-items-center">
                       <div class="btn-group">
                         <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                         <button type="button" class="btn btn-sm btn-outline-secondary" v-on:click.stop @click="deleteArticle(article.id)" id="deleteButton" >Delete</button>
                       </div>
                       <small class="text-muted">9 mins</small>
                     </div>
                   </div>
                 </div>
               </div>
         </div>

         <!-- This is for testing -->

         <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modalLarge">
               Large Demo Modal
           </button>

           <div class="modal fade modal-fullscreen" id="modalLarge" tabindex="-1" role="dialog" aria-labelledby="modalLargeLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" id="modalLargeLabel">Modal with large content</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                       </div>
                       
                           <textarea class="form-control" v-model="article.body"></textarea>
                       
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="button" id="btnTestSaveLarge" class="btn btn-default">
                               <span class="d-none d-md-inline">Save changes</span>
                               <span class="d-md-none">Save</span>
                           </button>
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
                  sarticles: [], // This is used for shortened articles
                  article: {
                     id: '',
                     title: '',
                     body: ''
                  },
                  article_id: '',
                  pagination: {},
                  edit: false,
                  search: ""
               }
            },
      
            created() {
               this.fetchArticles();
            },
      
            methods: {
               stopEditing(){
                  this.edit = false;
               },
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

                        this.fetchArticles();
                        
                     })
                     .catch(err => console.log(err));
                  }
               },
               clearArticle(){
                  this.edit=false;
                  this.article.id = '';
                  this.article_id = '';
                  this.article.title = '';
                  this.article.body = '';
               },
      
               addArticle() {
                  this.search = "";
                  
                  
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
                        $('.modal-backdrop').remove();
                        this.article.title='';
                        this.article.body='';
                        // alert('Article Added');

                        this.fetchArticles();
                        
                     })
                     .catch(err => console.log(err));
                     
                  }
                  else{
                     // Update
                     console.log("Came here");
                     
                     fetch('api/article',{
                        method: 'put',
                        body: JSON.stringify(this.article),
                        headers:{
                           'content-type': 'application/json'
                        }
                     })
                     .then(res =>res.json())
                     .then(data =>{
                        $('.modal-backdrop').remove();
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
                  $('.bd-example-modal-lg').modal('show');
                  this.edit = true;
                  this.article.id = article.id;
                  this.article.article_id = article.id;
                  this.article.title = article.title;
                  this.article.body = article.body;
               },
               
            },
            computed: {
                  filteredArticles:function(){
                     return this.articles.filter((article) =>{
                        console.log(this.search);
                        return ((article.title).toLowerCase()).match(((this.search).toLowerCase())) || ((article.body).toLowerCase()).match(((this.search).toLowerCase()));

                     });
                  }

               }
      
         }

         

</script>

