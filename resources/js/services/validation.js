export default class Validation {
    constructor() {
      this.messages = {};
    }
  
    getMessage(field) {
      console.log(this.messages)
      if (this.messages && this.messages[field]) {
        return this.messages[field][0];
      }
    }
  
    setMessages(messages) {
      this.messages = messages;
    }
  
    empty() {
      this.messages = {};
    }
  }
  