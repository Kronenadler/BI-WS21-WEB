import { Component, OnInit } from '@angular/core';
import { AfterViewChecked, ElementRef, ViewChild } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { Message } from 'src/app/models/Message';
import { BackendService } from 'src/app/services/backend.service';
import { ContextService } from 'src/app/services/context.service';
import { IntervalService } from 'src/app/services/interval.service';

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
    public messagedUser: string;

    public constructor(private router: Router, public contextService: ContextService, public backendService: BackendService,
            public intervalService: IntervalService) { 
        this.myScrollContainer = new ElementRef(null);

        this.messages = new Array();
        this.newMsg = "";
        this.messagedUser = "NAME";
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
        this.messagedUser = this.contextService.loggedInUsername;
        this.scrollToBottom();

        // Initially load data
        this.loadData();

        // Load data every x seconds
        this.intervalService.setInterval("reloadMessages", () => this.loadData());
    }

    public ngOnDestroy(): void {
        this.intervalService.clearIntervals();
    }

    public loadData(): void {
        this.backendService.listMessages(this.contextService.currentChatUsername).then((msgs: Array<Message>) => {
            if(msgs.length > 0) {
                console.log("Loaded Messages!"); // Todo Remove
                this.messages = msgs;
            }
        });
    }

    public sendMessage(form: NgForm): void {
        if(this.newMsg === ""){
            console.log("Didn't send message: was empty!");
        } else {
            this.backendService.sendMessage(this.contextService.currentChatUsername, this.newMsg).then((ok: boolean) => {
                if(ok) {
                    console.log("Message sent!");
                } else {
                    console.log("Error sending message!");
                }
            });
            form.reset();
            this.loadData();
        }
    }

    public formatTime(time: number): string {
        return new Date(time).toLocaleTimeString();
    }

    public removeFriend(): void {
        /*

        TODO:
        Asking to confirm removal via alert!

        */
        console.log("Removing Friend " + this.contextService.currentChatUsername);
        this.backendService.removeFriend(this.contextService.currentChatUsername).then((ok) => {
            if(ok) {
                console.log("Removed Friend"); // Todo Remove ?
                this.router.navigate(['/friends']);
            }
                
        })
    }

}
