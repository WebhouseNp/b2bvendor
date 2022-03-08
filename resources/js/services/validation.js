export default class Validation {
    constructor() {
      this.messages = {};
    }
  
    getMessage(field) {
      console.log('message', this.messages)
      if (this.messages && this.messages[field]) {
        const required = this.messages[field][0].search('required');
        if(required > 0){
          return 'This field is required';
        }else{
          return this.messages[field][0];
        }
       
      }
    }
  
    setMessages(messages) {
      this.messages = messages;
    }
  
    empty() {
      this.messages = {};
    }
  }
  