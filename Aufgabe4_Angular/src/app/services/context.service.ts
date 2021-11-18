import { Injectable } from '@angular/core';

@Injectable({
    providedIn: 'root'
})
export class ContextService {

    public loggedInUsername: string = '';
    public currentChatUsername: string = ''; 

    public constructor() { 
        console.log('*** context created ***');
    }

}
