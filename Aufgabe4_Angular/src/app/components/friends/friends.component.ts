import { Component, ComponentFactoryResolver, OnInit, OnDestroy } from '@angular/core';
import { Router } from '@angular/router';
import { User } from 'src/app/models/User';
import { Friend } from 'src/app/models/Friend';
import { ContextService } from 'src/app/services/context.service';
import { BackendService } from '../../services/backend.service';
import { NgForm } from '@angular/forms';
import { IntervalService } from 'src/app/services/interval.service';

@Component({
    selector: 'app-friends',
    templateUrl: './friends.component.html',
    styleUrls: ['./friends.component.css']
})

export class FriendsComponent implements OnInit {

    public friends: Array<Friend>;
    public requests: Array<Friend>;
    public unreadMsgs: Map<string, number>;

    public friendToAdd: string;

    /*
     * Initialize Site
     */
    public constructor(private router: Router, private contextService: ContextService, 
            private backendService: BackendService, private intervalService: IntervalService) {

        //this.user = new User();
        this.friends = new Array();
        this.requests = new Array();
        this.unreadMsgs = new Map();

        this.friendToAdd = "";
    }

    public ngOnInit(): void { 
        // Initially, load all data       
        this.loadData();

        // Load all the data every x seconds
        this.intervalService.setInterval("ReloadFriends", () => this.loadData());
    }

    public ngOnDestroy(): void {
        this.intervalService.clearIntervals();
    }

    public loadData(): void {
        console.log("----- Loading Data -----"); // Todo Remove

        // Load unread messages
        this.backendService.unreadMessageCounts().then((counts: Map<string, number>) => {
            this.unreadMsgs = counts;
        });

        // Load friends
        console.log("Current User: " + this.contextService.loggedInUsername); // Todo Remove
        this.backendService.loadFriends().then((friends: Array<Friend>) => {
            if(friends.length > 0) {
                console.log("Loaded Friends"); //Todo Remove

                // Add the unread messages count to the friends
                for(let friend of friends){
                    console.log("Friend: " + friend.username + " - " + friend.status); // Todo Remove
                    let i = this.unreadMsgs.get(friend.username);
                    if(i != undefined)
                        friend.unreadMessages = i; 
                    else {
                        friend.unreadMessages = 0;
                        console.log("Couldn't load unread messages for friend " + friend.username + "!");
                    }
                }

                // Fill all accepted friends to list
                this.friends = friends.filter((friend: Friend) => {
                    return friend.status === "accepted";
                });
                // Fill all requested friends to list
                this.requests = friends.filter((friend: Friend) => {
                    return friend.status === "requested";
                });
            }
        });
    }

    /*
     * Interact with friends
     */
    public chatFriend(friend: Friend): void {
        this.contextService.currentChatUsername = friend.username;

        console.log("Current User: " + this.contextService.loggedInUsername); // Todo Remove
        console.log("Chatted User: " + this.contextService.currentChatUsername); // Todo Remove
        this.intervalService.clearIntervals();
        this.router.navigate(['/chat']);
    }

    public acceptFriend(friend: Friend): void {
        this.backendService.acceptFriendRequest(friend.username).then(() => this.loadData());
    }

    public declineFriend(friend: Friend): void {
        this.backendService.dismissFriendRequest(friend.username).then(() => this.loadData());
    }

    public addFriend(addFriendForm: NgForm): void {
        if(this.friendToAdd != ""){
            console.log("Friend to Add: " + this.friendToAdd); // Todo Remove
            this.backendService.friendRequest(this.friendToAdd).then((ok: boolean) => {
                if(!ok){
                    console.log("Couldn't add friend!");
                } else
                    this.loadData();
            });
            addFriendForm.reset();
        } else {
            console.log("Add button pressed, but noone to add!");
        }
    }
}
