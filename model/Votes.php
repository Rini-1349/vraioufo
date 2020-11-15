<?php

require_once('Manager.php');

class Votes extends Manager
{
    public function getVotesByPost($postId)
    {
        $db = $this->dbConnect();
        $votes = $db->prepare('SELECT * FROM votes WHERE post_id = :postId');
        $votes->execute(array(
            'postId' => $postId
        ));

        return $votes;
    }

    public function addVote(array $vote)
    {
        $db = $this->dbConnect();
        $newVote = $db->prepare('INSERT INTO votes (user_id, post_id, value) VALUES (:userId, :postId, :value)');

        $newVote = $newVote->execute([
            'userId' => $vote['userId'],
            'postId' => $vote['postId'],
            'value' => $vote['value']
        ]);

        return $newVote;
    }

    public function deleteVotesOfPost($postId)
    {
        $db = $this->dbConnect();
        $votes = $db->prepare('DELETE FROM votes WHERE post_id = :postId');
        $deletedVotes = $votes->execute(['postId' => $postId]);

        return $deletedVotes;
    }

    public function deleteVotesFromUser($userId)
    {
        $db = $this->dbConnect();
        $votes = $db->prepare('DELETE FROM votes WHERE user_id = :userId');
        $deletedVotes = $votes->execute(['userId' => $userId]);

        return $deletedVotes;
    }
}