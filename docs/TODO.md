# To-do list

## Main features

### Members

- [x] Register
- [x] Log in
- [x] Log out
- [ ] Update member info
- [x] Search for books
- [ ] Add books to make reservation
- [ ] Show all books for reservation
- [ ] Cancel reservation
- [ ] Show borrowed books

### Librarians

- [x] Log in
- [x] Log out
- [x] Add books
- [x] Remove books
- [x] Search books
- [ ] Modify books' info
- [x] Show all reservation requests
- [x] Add record
- [x] Remove record
- [ ] Total of borrowed book

### Admin

- [x] Log in
- [x] Log out
- [x] Add employees
- [ ] Modify employees' info
- [ ] Remove employees

## Optional features

- [ ] Request for membership cancellation (only if they pay all the fines)
- [ ] Delete inactive members
- [ ] Notify when the return date approaches
- [ ] Pay fines
- [ ] Total of (un)paid fines

## App flow

Member login/register to the database

**For reservation**
Member request reservation

- Add to the reservation record

Member goes to library to pick up at pickup date

- Librarian verifies the reservation
- Delete the reservation record
- Add new borrow record

If member don't show up at the pick up date

- Delete the reservation record (automatically - maybe?)

**For borrowing**
Librarian add borrowing book record

**Return date**
Librarian delete the borrowing book records
