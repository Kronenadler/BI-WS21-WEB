import { Component, OnInit } from '@angular/core';
import { AfterViewChecked, ElementRef, ViewChild } from '@angular/core';
import { Form } from '@angular/forms';
import { Message } from 'src/app/models/Message';
import { BackendService } from 'src/app/services/backend.service';
import { ContextService } from 'src/app/services/context.service';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.css']
})

export class ChatComponent implements OnInit, AfterViewChecked {
    // DIV für Nachrichten (s. Template) als Kind-Element für Aufrufe (s. scrollToBottom()) nutzen
    @ViewChild('messagesDiv') private myScrollContainer: ElementRef;

    public messages: Array<Message>;
    public newMsg: string;

    public constructor(public contextService: ContextService, public backendService: BackendService) { 
        this.myScrollContainer = new ElementRef(null);

        this.messages = new Array();
        this.newMsg = "";
    }

    public ngAfterViewChecked() {        
        this.scrollToBottom();        
    } 

    /**
     * Setzt in der Nachrichtenliste die Scrollposition ("scrollTop") auf die DIV-Größe ("scrollHeight"). Dies bewirkt ein 
     * Scrollen ans Ende.
     */
    private scrollToBottom(): void {
        try {
            this.myScrollContainer.nativeElement.scrollTop = this.myScrollContainer.nativeElement.scrollHeight;
        } catch(err) { 
        }                 
    }

    public ngOnInit(): void {
        this.scrollToBottom();
        this.loadData();
    }

    public loadData(): void {
        this.backendService.listMessages(this.contextService.currentChatUsername).then((msgs: Array<Message>) => {
            if(msgs.length > 0) {
                console.log("Loaded Messages!");
                this.messages = msgs;
            }
        });
    }

    public sendMessage(form: Form): void {
        if(this.newMsg === ""){
            console.log("Didn't send message: was empty!");
        } else {
            this.backendService.sendMessage(this.contextService.currentChatUsername, this.newMsg).then((ok: boolean) => {
                if(ok) {
                    console.log("Message sent!");
                } else {
                    console.log("Error sending message!");
                }
            })
        }
    }

}
