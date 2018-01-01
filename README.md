# SaaSsy Cloud

[Welcome](#welcome) | [Signup Site](#signup-site) | [Dashboard](#dashboard) | [Domain Model](#domain-model) | [Technologies Used](#technologies-used)

## Welcome
My name is Jason Ross. I am a full stack Software Engineer who loves building things.
This is a simple demo site where the aim is not to sell power-ups, but to demonstrate Software Engineering skills.
       
You can find a live demo of this source code at [https://saassycloud.com](https://saassycloud.com)

- The sign up site is made with Laravel 5.5 on top of PHP 7.1.  The layout uses Bootstrap 4, beta 2. More details can be found on the Sign Up Site tab above.

- The [admin dashboard](https://saassycloud.com/admin/dashboard) is made with javascript. Primarily ECMAScript 6 ( ES6 ), Vue.js and chart.js with some 
help from some common libraries. More details can be found on the Dashboard tab above.

- The links above describe the architecture of this site, each detailing the design patterns, technologies, frameworks and libraries used for the main two sections,
the sign up site and the admin dashboard. The Domain Model tab shows the Domain Model and the underlying relational data model used for this site, and the Technologies Used tab is a simple list of technologies.

- You can access this modal on any page of the site by clicking on the "Show Info Modal" button on the footer.
  
Thanks for checking it out! If you have any questions, suggestions, or would like to discuss anything tech related, drop me a line at jason.ch.ross@gmail.com
 
I will be setting up another version of this site using node.js, express and a NoSQL data store, MongoDB for the backend.
That project's source code (will live) lives at [https://github.com/jasonarg/saassycloud-node](https://github.com/jasonarg/saassycloud-node).
  
  
## Signup Site

### Concept

This demo site is a simple sign up site for a fictional SaaS product, SaaSsy Cloud.
It consists of a home page and a product package comparison page that funnels potential
customers to a three step form to sign up for a free trial.

Behind the scenes, all site requests and input are tracked and recorded in a normalized relational database.
When a new session is started and the visitor lands on the comparison page, a new
ConversionOpportunity object is created, where one of two A/B testing views is assigned to that
visitor's session.

This A/B view is permanent throughout the session lifetime.  This allows for easy A/B testing
and performance comparisons.  It allows you to see which layout is more effective at converting
opportunities to trial users, and then to keep refining and experimenting with different layouts, prices,
or anything really, to maximize profitability or user satisfaction.

The Dashboard tab above talks in depth about the functionality of the analytics generated by the
Session, SessionRequest, SessionResponse and ConversionOpportunity objects that are invoked on nearly
every page view.    

### Architecture   

SaaSsy Cloud runs on a robust Domain Model implemented in Laravel's Eloquent ORM, an Active
Record implementation. I am a firm believer in Eric Evan's Domain Driven Design. I believe a good domain model
has many benefits, including reducing development time, extending the serviceable life of a piece of software,
improving the software's usefulness and maximizing stakeholder satisfaction.
   
Above the persistence layer, the application uses the tried and true MVC pattern as implemented by Laravel.
   
The Model, built on top of Eloquent, has three domains, namespaced separately from each other. Core, Product and Tracking.
The model is accessed via Application Services which use the Repository pattern to access the ActiveRecord models themselves in order to
do typical CRUD operations.
   
The Views of the site use laravel's blade templates.  For the most part, they use the typical layout pattern with page specific content yielded to them.
Common partials/includes are also used extensively. The views generate html markup which use Bootstrap 4 to create responsive layouts
in Bootstrap's ubiquitous grid system.
        
The Controllers used are very lightweight.  The web routes of SaaSsy Cloud call controllers that
use Laravel's famous Dependency Injection / Inversion of Control implementation, Service Container, to map concrete implementations of interfaces (or contracts) that
are used by controllers to access the domain model through repositories.
    
In addition to the MVC components, this app also takes advantage of custom middleware to track user activity.  These
middleware components invoke application services that track session activity, conversion and sign up form progress. Laravel's
storage system is also used for keeping files out of the public view.
  
Beyond the HTML side of things, this app also uses Laravel 5.5's new Resource classes to wrap the domain model
in a thin layer to create a REST API using JSON as the payload. This API is used to feed the Admin Dashboard, described in the next tab.
            
## Dashboard

### Concept
  
The admin dashboard displays the data recorded throughout the sign up site.
  
It is written purely in javascript using new ES6 features such as classes, arrow functions, string templates,
block scope variables (let), modules and promises (the node.js version of SaaSsy Cloud will use ES8 Async/Await).
    
The dashboard uses Vue.js, a reactive javascript user interface library very similar to Facebook's React and Google's Angular frameworks,
to render the Bootstrap 4 HTML 5 markup and to listen to events that change the range of the dashboard data.
The final major piece of the dashboard is the chart.js canvas based charting library, to render the charts of the dashboard.
                
### Architecture

The dashboard is controlled by a single ES6 Class, ScDashboard, which reads in JSON files for
navigation layout and dashboard layout.
These JSON files inform ScDashboard how to layout a given dashboard (the rows and columns of charts
needed), what data to request from the API via Axios,
and where to look for the rough data polishing, dataset creation and label creation functions
for each chart of a given dashboard (it looks for a class
that extends ScChart, and is loaded by the proxyClassLoader function.
         
These JSON files also contain the data structures Vue.js needs in order to compose all of it's components.
   
Instead of using Vue's Vuex, similar to React's Redux, to control the application state, I decided
to use ScDashboard as the central nervous system of the Dashboard.
No good reason, I just wanted to do it manually, and besides, this dashboard is not that complex as far as
javascript apps go. The node.js version of SaaSsy Cloud will use an App State manager to demonstrate my proficiency with those tools.
                        
    
 ### Diagram & Application Flow 
 
 #### Diagram
    
 ![dashboard-architecture-small](https://user-images.githubusercontent.com/34226660/34470532-2bf7e838-ef01-11e7-816a-b787de5b68cd.jpg)
 
 **LoFi diagram of the dashboard application architecture**
 
 #### Application Flow
 
 <ol>
     <li>ScDashboard is instantiated</li>
     <li>constructor calls this.getRoute()
         <ul>
             <li>getRoute() sets this.route to the current route</li>
         </ul>
     </li>
     <li>constructor calls this.loadConfig()
         <ul>
             <li>loads the config/navigation.json file</li>
             <li>loads all of the layout.json files for each dashboard in navigation.json</li>
             <li>sets this.scdbData.layout.dashboard equal to the dashboard name matching the current route</li>
             <li>sets the default date range for the data</li>
         </ul>
     </li>
     <li>constructor calls this.loadData()
         <ul>
             <li>aysnc call is made with axios using a promise to the api route matching the current dashboard name and the current date range</li>
             <li>promise chain is registered to complete after the data returns</li>
             <li>this.polishDataAndLoadIntoChart() is registered as the fulfilled promise function</li>
         </ul>
     </li>
     <li>constructor calls this.loadView()
         <ul>
             <li>the Vue.js instance is loaded</li>
             <li>this.scdb.data is passed into the instance as the data property</li>
             <li>the top level single file component, Dashboard.vue is loaded with all reactive properties initialized
                 <ul>
                     <li>all ancestor components are then loaded with their needed props passed down accordingly</li>
                     <li>the components loaded are defined in the layout.json file for the current dashboard</li>
                 </ul>
             </li>
         </ul>
     </li>
     <li>constructor calls this.loadEventListeners()
         <ul>
             <li>registers two event listeners for when data is changed</li>
             <li>changeRange event is emitted from the RangePicker.vue component
                 <ul>
                     <li>updates scdbData range property, triggers a new loadData() call to get new data for the selected date range</li>
                 </ul>
             </li>
             <li>changeDashboard event is emitted from the SbNavListItem.vue component
                 <ul>
                     <li>currently does nothing (i need to define the other dashboards), but will set the current dashboard config to the selected listItem</li>
                     <li>then will call loadData and layout the new dashboard</li>
                 </ul>
             </li>
         </ul>
     </li>
     <li>promise from loadData is fulfilled</li>
     <li>a listing of each chart of the current dashboard is recursively extracted from the layout.json file data</li>
     <li>each chart's config class is instantiated
         <ul>
             <li>these classes extend ScChart</li>
             <li>they all have three methods, polishData, setLabels, and makeDatasets</li>
         </ul>
     </li>
     <li>the result data from the api is polished according to each chart's needs</li>
     <li>all data sets and chart labels are generated based on the functions defined in each of the chart config class</li>
     <li>for each chart of the current dashboard
         <ul>
             <li>if the chart has not been loaded before, a new Chart.js Chart class is instantiated and associated to the correct vdom element. a reference to this chart is stored in this.scdbData</li>
             <li>else, the Chart.js update api is used to update the data of the existing Chart instance</li>
         </ul>
     </li>
 </ol>
 
This architecture allows for the easy addition of new datasets, charts and dashboards.
You just copy a concrete ScChart class, modify the data manipulation functions, and edit or add a layout.json file.
 
## Domain Model

![model-whole](https://user-images.githubusercontent.com/34226660/34470536-2c21ac04-ef01-11e7-97fc-10813279403c.jpg)
                                   
**The SaaSsy Cloud Domain Model**
 
![model-core](https://user-images.githubusercontent.com/34226660/34470533-2c04285a-ef01-11e7-97da-f07b2a243ff8.jpg)
 
**The Core Domain Model, classes used in multiple contexts** 

![model-product](https://user-images.githubusercontent.com/34226660/34470534-2c0e42ae-ef01-11e7-977d-6979ab316428.jpg)

**The Product Domain Model, classes used to define SaaSsy Cloud products, packages, and their limits**

![model-tracking](https://user-images.githubusercontent.com/34226660/34470535-2c182df0-ef01-11e7-9055-e3dcb35433eb.jpg)

**The Tracking Domain Model, classes used to track visitor activity and to assign A/B views on saassycloud.com**

The Domain Model is broken up into three bounded contexts, and represented as separate namespaces. They are Core, Product and Tracking.

<ul>
    <li>
        The Core model includes entities that are vital to the site, and often times used by many other entities.
    </li>
    <li>
        The Product model defines a product system, which has product packages associated to it.
        These product packages have features with limits based on which product package is related to the feature. The product features are related to groups.
        SaaSsy Cloud is the ProductSystem. SaaSsy, SaaSsier, and SaaSsiest are ProductPackages.
        1up Mushroom, Big Mushroom, Mega Mushroom, etc. are ProductFeatures, belonging to the Mushroom ProductFeatureGroup with different limits of each feature per package.
    </li>
    <li>
        The Tracking model is built around the Session Aggregate and the ConversionOpportunity. ConversionOpportunity tracks which A/B View Group was assigned to the ConversionOpportunity and Session via relationship.
        ConversionOpportunity also tracks the input and the progress of each ConversionOpportunity along the sales funnel.
    </li>
</ul>                         
     
These entities are wrapped by Application Services and API Resource classes for access to it from higher level application layers. Each AggregateRoot also has a Repository is used for crud operations.
                                                
A good Domain Model allows for easy refactoring during development or down the road for new feature development.  It uses the language of the domain it represents to
describe entities and methods. They also can be used in more than one context, if designed and used correctly. They are one of the biggest ways to maximize the return of software development resources.

This is the first project that I have implemented a Domain Model in the Active Record design pattern. Previously I have used
a custom written temporal Data Mapper based ORM, similar to Java's Hibernate or PHP's Doctrine to implement Domain Models.
While Data Mapper ORMs are incredibly powerful and flexible, I have found this project to be a breeze to implement and not
too many trade offs were needed to use Active Record. I do have extensive Active Record (along with Table Data Gateways and
Data Access Objects) experience, just not in conjunction with a true Domain Model.
 
 
## Technologies Used

### Back End

<ul>
    <li>PHP 7.1</li>
    <li>Laravel 5.5
        <ul>
            <li>Eloquent ORM
                <ul>
                    <li>Many to One Relationships</li>
                    <li>One to One Relationships</li>
                    <li>Many to Many Relationships</li>
                    <li>Polymorphic Relationships</li>
                    <li>Polymorphic Many to Many Relationships</li>
                    <li>Repositories</li>
                    <li>Repository Interfaces</li>
                    <li>Eager Loading</li>
                </ul>
            </li>
            <li>Migrations</li>
            <li>API Resource Classes
                <ul>
                    <li>Item</li>
                    <li>Collections</li>
                </ul>
            </li>
            <li>Storage
                <ul>
                    <li>Public</li>
                    <li>Private (User content)</li>
                </ul>
            </li>
            <li>Customized Auth</li>
            <li>Custom Middleware</li>
            <li>Mix (a Webpack wrapper)</li>
            <li>Named Routes</li>
            <li>Blade Templates</li>
            <li>Views</li>
            <li>Service Container</li>
        </ul>
    </li>
    <li>MariaDB 10
        <ul>
            <li>Relational Data Model in 1NF</li>
        </ul>
    </li>
    <li>Active Record</li>
    <li>RESTful JSON API</li>
    <li>Domain Model</li>
</ul>

### Front End

<ul>
    <li>javascript
        <ul>
            <li>ES6 ( ECMAScript 6)</li>
            <li>Vue.js 2.x</li>
            <li>Chart.js</li>
            <li>d3</li>
            <li>axios</li>
            <li>lodash</li>
            <li>json-loader</li>
        </ul>
    </li>
    <li>Bootstrap 4
        <ul>
            <li>some minor jQuery snippets that bootstrap depends on</li>
        </ul>
    </li>
    <li>SASS</li>
</ul>      


*Disclaimer: If you do review this site, there are obviously many elements that are
over-engineered and other elements that have no business being in a production site. This is a demo
site, my goal was just to show I know how to do certain things.*

*This README.md file's content can be found on the live site.  It appears as a modal by default on the home page and can be launched from the footer of every page.*
                                                                                                                                                                                                                                                             